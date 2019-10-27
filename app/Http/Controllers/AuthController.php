<?php

namespace App\Http\Controllers;


use App\Events\AccountWasCreated;
use App\User;
use App\Admin;
use App\CareerPath;
use App\TwitterTokens;
use GuzzleHttp;
use App\Http\Requests;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Libraries\APIHandler;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use App\Libraries\AuthenticateUser;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Notifications\CareerPathSaved;
use Illuminate\Support\Facades\Notification;

use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;
use Keygen\Keygen;

class AuthController extends Controller
{

    private $user;
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('jwt.auth', ['except' => ['authenticate', 'register', 'twitter', 'facebook', 'linkedin', 'verify', 'verifyPasswordReset']]);

        $this->twitter_consumer_key = config('services.twitter.client_id');
        $this->twitter_secret= config('services.twitter.client_secret');
        $this->userRepository = $userRepository;
        $this->user = new User();
    }


    /**
     * Create account with Email and password
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function register(Request $request)
    {
        try {
            $careerFits = '';
            $userData = $request->only([
                'firstName',
                'lastName',
                'name',
                'whatsAppNumber',
                'accountType',
                'username',
                'email',
                'password',
                'careerFit'
                ]);
            if (array_key_exists('paths', $userData['careerFit'])) {
                $careerPathIds = array_pluck($userData['careerFit']['paths'], 'id');
                $careerPaths = CareerPath::whereIn('id', $careerPathIds)->get()->toArray();
                $careerFits = implode(", ", array_pluck($careerPaths, 'name'));
            }

            $validator = $this->user->validate($userData);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }

            $userData['verificationCode'] = Keygen::numeric(6)->generate();
            $user = $this->userRepository->saveNew($userData);

            if (!empty($careerFits)) {
                $slackNotificationData = $this->extractSlackNotificationData($userData, $careerFits);
                $user->careerPaths()->attach($careerPathIds);
                Notification::send(Admin::first(), new CareerPathSaved($slackNotificationData));
            }
            
            $token = JWTAuth::fromUser($user);
            Event::fire(new AccountWasCreated($user, $userData['verificationCode']));
        } catch (\Exception $ex) {
            return response(['message' => $ex->getMessage()]);
        }

        return response()->json(['token' => $token]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function facebook(Request $request)
    {
        $client = new GuzzleHttp\Client();
        $params = [
            'code' => $request->input('code'),
            'client_id' => $request->input('clientId'),
            'redirect_uri' => $request->input('redirectUri'),
            'client_secret' => config('services.facebook.client_secret')
        ];
        // Step 1. Exchange authorization code for access token.
        $accessTokenResponse = $client->request('GET', 'https://graph.facebook.com/v2.5/oauth/access_token', [
            'query' => $params
        ]);
        $accessToken = json_decode($accessTokenResponse->getBody(), true);
        // Step 2. Retrieve profile information about the current user.
        $fields = 'id,email,first_name,last_name,link,name';
        $profileResponse = $client->request('GET', 'https://graph.facebook.com/v2.5/me', [
            'query' => [
                'access_token' => $accessToken['access_token'],
                'fields' => $fields
            ]
        ]);
        $profile = json_decode($profileResponse->getBody(), true);

        $_user = User::where('email', $profile['email'])->first();
        // If user already has an account with email address, link the facebook account with existing account
        if ($_user) {
            $_user->facebook = $profile['id'];
            $_user->updated_at = \Carbon\Carbon::now();
            $_user->save();

            return response()->json(['token' => JWTAuth::fromUser($_user)]);
        }

        // Step 3a. If user is already signed in then link accounts.
        if ($request->header('Authorization')) {
            $user = User::where('facebook', '=', $profile['id']);
            if ($user->first())
            {
                return response()->json(['message' => 'There is already a Facebook account that belongs to you'], 409);
            }
            $token = explode(' ', $request->header('Authorization'))[1];
            $payload = (array) JWT::decode($token, config('jwt.secret'), array('HS256'));
            $user = User::find($payload['sub']);
            $user->facebook = $profile['id'];
            $user->email = $user->email ?: $profile['email'];
            $user->name = $user->name ?: $profile['name'];
            $user->save();

            return response()->json(['token' => JWTAuth::fromUser($user)]);
        } else {
            $user = User::where('facebook', '=', $profile['id']);
            if ($user->first()) {
                return response()->json(['token' => JWTAuth::fromUser($user->first())]);
            }
            $user = new User;
            $user->facebook = $profile['id'];
            $user->email = $profile['email'];
            $user->name = $profile['name'];
            $user->last_name = $profile['last_name'];
            $user->first_name = $profile['first_name'];
            $user->save();
            return response()->json(['token' => JWTAuth::fromUser($user)]);
        }
        
        
    }

    public function twitter(Request $request)
    {
        if (!$request->input('oauth_token') || !$request->input('oauth_verifier')) {      
            $twitterOAuth = new \Abraham\TwitterOAuth\TwitterOAuth($this->twitter_consumer_key, 
                            $this->twitter_secret);
            $request_token = $twitterOAuth->oauth('oauth/request_token', array('oauth_callback' => $request->input('redirectUri')));
            $tokens = TwitterTokens::create($request_token);

            return response()->json(['oauth_token'=> $request_token['oauth_token']]);

        } else {
            $token = TwitterTokens::where('oauth_token', $request->input('oauth_token'))->first(); 
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth(
                            $this->twitter_consumer_key, 
                            $this->twitter_secret, 
                            $request->input('oauth_token'), 
                            $token->oauth_token_secret// twitter secret from DB
                            );
        
            $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $request->input('oauth_verifier')]); 
            $twitterOAuth = new \Abraham\TwitterOAuth\TwitterOAuth( $this->twitter_consumer_key, $this->twitter_secret, $access_token['oauth_token'], $access_token['oauth_token_secret'] );
            $twitterUser = $twitterOAuth->get('account/verify_credentials', ['include_entities' => 'false','include_email'=>'true','skip_status'=>'true',]);
            $user = User::where('email', $twitterUser->email)->first();
            if ($user) {
                $user->name = $twitterUser->name;
                $user->twitter_handle = $twitterUser->screen_name;
                $user->avatar_uri = $user->avatar_uri ? : $twitterUser->profile_image_url_https;
                $user->email = $user->email ? : $twitterUser->email;
                $user->save();
                return response()->json(['token' => JWTAuth::fromUser($user)]);
            }
            $user = new User;
            $user->twitter = $twitterUser->id;
            $user->name = $twitterUser->name;
            $user->username = $twitterUser->screen_name;
            $user->location = $twitterUser->location;
            $user->website = $twitterUser->url;
            $user->about = $twitterUser->description;
            $user->email = $twitterUser->email;
            $user->avatar_uri = $twitterUser->profile_image_url_https;
            $user->save();

            return response()->json(['token' => JWTAuth::fromUser($user)]);
        }
    }

    public function linkedin(Request $request)
    {
        $client = new GuzzleHttp\Client();
        $params = [
            'code' => $request->input('code'),
            'client_id' => $request->input('clientId'),
            'client_secret' => config('services.linkedin.client_secret'),
            'redirect_uri' => $request->input('redirectUri'),
            'grant_type' => 'authorization_code',
        ];
        // Step 1. Exchange authorization code for access token.
        $accessTokenResponse = $client->request('POST', 'https://www.linkedin.com/uas/oauth2/accessToken', [
            'form_params' => $params
        ]);
        $accessToken = json_decode($accessTokenResponse->getBody(), true);
        // Step 2. Retrieve profile information about the current user.
        $profileResponse = $client->request('GET', 'https://api.linkedin.com/v1/people/~:(id,first-name,last-name,email-address)', [
            'query' => [
                'oauth2_access_token' => $accessToken['access_token'],
                'format' => 'json'
            ]
        ]);
        $profile = json_decode($profileResponse->getBody(), true);

        $_user = User::where('email', $profile['emailAddress'])->first();
        // If user already has an account with email address, link the linkedin account with existing account
        if ($_user) {
            $_user->linkedin = $profile['id'];
            $_user->updated_at = \Carbon\Carbon::now();
            $_user->save();

            return response()->json(['token' => JWTAuth::fromUser($_user)]);
        }

        // Step 3a. If user is already signed in then link accounts.
        if ($request->header('Authorization')) {
            $user = User::where('linkedin', '=', $profile['id']);
            if ($user->first()) {
                return response()->json(['message' => 'There is already a LinkedIn account that belongs to you'], 409);
            }
            $token = explode(' ', $request->header('Authorization'))[1];
            $payload = (array) JWT::decode($token, config('jwt.secret'), array('HS256'));
            $user = User::find($payload['sub']);
            $user->first_name = $profile['firstName'];
            $user->last_name = $profile['lastName'];
            $user->linkedin = $profile['id'];
            $user->name = $user->name ?: $profile['firstName'] . ' ' . $profile['lastName'];
            $user->username = $profile['firstName'].$profile['lastName'].random_int(100, 10000);
            $user->email = $profile['emailAddress'];
            $user->save();
            return response()->json(['token' => JWTAuth::fromUser($user)]);
        }
        // Step 3b. Create a new user account or return an existing one.
        else {
            $user = User::where('linkedin', '=', $profile['id']);

            if ($user->first()) {
                return response()->json(['token' => JWTAuth::fromUser($user->first())]);
            }
            $user = new User;
            $user->linkedin = $profile['id'];
            $user->first_name = $profile['firstName'];
            $user->last_name = $profile['lastName'];
            $user->name =  $profile['firstName'] . ' ' . $profile['lastName'];
            $user->username = $profile['firstName'].$profile['lastName'].random_int(100, 10000);
            $user->email = $profile['emailAddress'];
            $user->save();

            return response()->json(['token' => JWTAuth::fromUser($user)]);
        }

    }

    public function verify(Request $request)
    {
        try {
            $user =  JWTAuth::parseToken()->authenticate();
            $verificationCode = $request->get('verification_code');
            $user = User::where('verification_code', $verificationCode)
                ->where('id', $user['id'])->first();
            if (is_null($user)) {
                return response()->json(['message' => 'Invalid account or verification code'], 400);
            }
            $user->status = 1;
            $user->save();
            $token = JWTAuth::fromUser($user);
            return response()->json(['user' => $user, 'token' => $token, 'message' => "Account activation successful", 'success' => true], 200);
        } catch (JWTException $ex) {
            return response()->json(['message' => $ex->getMessage(), 'success' => false ], 400);
        }
    }

    public function resendVerificationCode(Request $request)
    {
        try {
            $user =  JWTAuth::parseToken()->authenticate();
            $user = User::find($user['id']);
            $verificationCode = Keygen::numeric(6)->generate();
            $user->verification_code = $verificationCode;
            $user->save();
            Event::fire(new AccountWasCreated($user, $verificationCode));

            return response()->json(['user' => $user, 'message' => "Activation code has been sent to your email"], 200);

        } catch (JWTException $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    public function verifyPasswordReset(Request $request)
    {
        try {
            $token = new Token($request->get('token'));
            $user =  JWTAuth::decode($token);
            $user = User::find($user['sub']);
            $token = JWTAuth::fromUser($user);
            return ['user' => $user, 'token' => $token];
        } catch (JWTException $ex) {
            return response()->json(['message' => $request->get('token')], 400);
        }
    }

    private function extractSlackNotificationData($userData, $careerFits)
    {
        $slackNotificationData = [
            'email' => $userData['email'],
            'fullName' => $userData['name'],
            'careerFits' => $careerFits,
            'score' => $userData['careerFit']['score'],
            'whatsAppNumber' => $userData['whatsAppNumber']
        ];

        return $slackNotificationData;
    }

}
