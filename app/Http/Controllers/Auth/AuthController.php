<?php

namespace App\Http\Controllers\Auth;



use App\Repositories\UserRepository;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use App\Libraries\AuthenticateUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginPath = 'login';

    protected $username = 'email';

    protected $redirectPath = "/dashboard";
    
    private $userRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        
        $this->userRepository = new UserRepository();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     * Default Sign Up
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function register(Request $request)
    {
        // Get credentials from form
        $credentials = $request->only(['first_name', 'last_name', 'username', 'email', 'password']);

        // Validation rules
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8'
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $user = new User;

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->name = $request->first_name." ".$user->last_name;
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->password = bcrypt($request->get('password'));
        $user->verification_code = str_random(30);
        $user->save();

        // Send Verification code to email
        $uc = new UserController($this->userRepository);

        $uc->sendEmailAccountVerification($user->id);
        
        return view('onboarding.emailSent')->with('user', $user);
    }

    /**
     * Handles login with social media accounts
     * @param AuthenticateUser $authenticateUser
     * @param Request $request
     * @param null $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(AuthenticateUser $authenticateUser , Request $request, $provider = null)
    {
        try
        {
            return $authenticateUser->execute($request->all(), $this, $provider);

        }
        catch (\Exception $ex)
        {
            return back()->with('failure', "An error occurred")->withInput();
        }
    }


    /**
     * Send email account verification
     * @param $id
     */
    public function sendEmailAccountVerification($id)
    {
        $user = User::findOrFail($id);

        Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
            $message->from('noreply@meetrabbi.com', 'Meetrabbi');
            $message->subject('Welcome to Meetrabbi');
            $message->to($user->email, $user->name);
        });
    }

    public function authenticated()
    {
        // Go to onboarding if user has not been onboarded.
        if (Auth::user()->status != 2)
        {
            return redirect('onboarding');
        }
        
        return redirect()->intended($this->redirectPath());

    }

    public function resendEmailVerification(Request $request)
    {
        $id = $request->get('user_id');

        $this->sendEmailAccountVerification($id);

        $user = User::find($id);

        return view('onboarding.emailSent')->with('user', $user);
    }

    

}
