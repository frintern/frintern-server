<?php

namespace App\Http\Controllers;

use App\Education;
use App\Events\ConfirmResetPasswordWasTriggered;
use App\Events\Event;
use App\Experience;
use App\Follow;
use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use App\Mentor;
use App\Interest;
use App\Repositories\MentorRepository;
use App\Repositories\ResourceRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Parser\Token;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    private $userRepository;
    private $resourceRepository;
    private $mentorRepository;
    private $education, $experience;
    private $user;

    public function __construct(UserRepository $userRepository, User $user, Education $education, Experience $experience)
    {
        $this->middleware('jwt.auth');

        $this->userRepository = $userRepository;
        $this->resourceRepository = new ResourceRepository();
        $this->mentorRepository = new MentorRepository();
        $this->education = $education;
        $this->experience = $experience;
        $this->user = $user;
    }


    /** User follows another user
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function follow(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $follow = [
            'user_id' => $request->get('user_id'),
            'followed_by' => $currentUser['id'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ];

        $rules = [
            'user_id' => 'required|integer',
            'followed_by' => 'required|integer'
        ];

        $validator = Validator::make($follow, $rules);

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors());
        }

        // Check if user is already following you
        $mutual = Follow::where('followed_by', $request->get('user_id'))
            ->where('user_id', $currentUser['id'])->first();

        if ($mutual) {
            // update mutual
            Follow::where('user_id', $currentUser['id'])->where('followed_by', $request->get('user_id'))
                ->update(['mutual' => 1]);
        } else {
            // insert a new follow relationship
            Follow::insert($follow);
        }
        
        $data = [
            'user' => User::find($request->get('user_id')),
            'followed_by' => $currentUser
        ];
        
        Mail::send('emails.follow', ['data' => $data], function($message) use($data){
            $message->from("notification@meetrabbi.com", "MeetRabbi");
            $message->to($data['user']->email, $data['user']->name);
            $message->subject($data['followed_by']->first_name . " is now following you on MeetRabbi!");
        });

        return APIHandler::response(1, "You are now following this user");
    }

    /**
     * User unfollows another user
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function unfollow(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $userToUnfollow = $request->get('user_id');

        // Check if the follow relationship is mutual
        $mutual = $mutual = Follow::where('followed_by', $request->get('user_id'))
            ->where('user_id', $currentUser['id'])->where('mutual', 1)->first();

        if ($mutual) {
            // update mutual
            Follow::where('user_id', $currentUser['id'])->where('followed_by', $request->get('user_id'))
                ->update(['mutual' => 0]);
        } else {
            // delete follow relationship from storage
            DB::table('follows')
                ->where('user_id', $userToUnfollow)
                ->where('followed_by', $currentUser['id'])
                ->delete();

        }

        return APIHandler::response(1, "You have unfollowed this user.");
    }


    /**
     * Get all users that are you are not following : For people
     * @return \App\Libraries\Response
     */
    public function getAllUsers()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        try {

            $following = DB::table('follows')
                ->select('user_id as follower_id')
                ->where('followed_by', $currentUser['id'])->get();

            // Mutual follows
            $mutualFollowing = DB::table('follows')->select('followed_by as follower_id')
                ->where('user_id', $currentUser['id'])
                ->where('mutual', 1)->get();

            $followerIds = [];
            $ffs = count($mutualFollowing) > 0 ? array_merge($following, $mutualFollowing) : $following;
            foreach($ffs as $following) {
                array_push($followerIds, $following->follower_id);
            }
            array_push($followerIds, $currentUser['id']);
            $data['people'] =  User::select('users.*')->whereNotIn('id', $followerIds)->get();

            return APIHandler::response(1, "People", $data);
        } catch(\Exception $ex) {
            return APIHandler::response(0, $ex->getMessage());
        }
    }

    /**
     * Onboard new user
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function onBoard(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $params = [
            'status' => 1,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'about' => $request->get('about'),
            'location' => $request->get('location')
        ];

        $data['user'] = User::where('id', $currentUser['id'])->update($params);

        $interests = $request->get('interests');

        try {
            $this->userRepository->storeInterests($currentUser['id'], $interests);

            // Update user status to onboarded
            User::where('id', $currentUser['id'])->update(['status' => 2]);

        }
        catch(\Exception $e) {
            return $e->getMessage();
        }

        return APIHandler::response(1, "User onboarded", $data);

    }


    /**
     * Returns the private profile, usually should be requested by the owner of the account
     * */
    public function getPrivateUserProfile()
    {
        // Get user details from token
        $user = JWTAuth::parseToken()->authenticate();

        return $this->userRepository->getUserProfileData($user['id']);

    }

    /**
     * Returns the public profile of a particular user
     * @param $id
     * @return \App\Libraries\Response
     */
    public function getPublicUserProfile($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $userProfile = $this->userRepository->getUserProfileData($id, $currentUser['id']);

        return $userProfile;
    }
    
    /**
     * Become a mentor
     * @param $id
     */
    public static function becameAMentor($id)
    {
        User::where('id', $id)->update(['is_a_mentor' => 1]);
    }

    /**
     * get the followers of a user
     * @param $id
     * @return \App\Libraries\Response
     */
    public function followers($id)
    {
        // All followers
        $data['followers'] = $this->userRepository->getFollowers($id);

        return APIHandler::response(1, "Followers", $data);
    }

    /**
     * Get the users followed of another user
     * @param $id
     * @return \App\Libraries\Response
     */
    public function following($id)
    {

        // All following
        $data['following'] = $this->userRepository->getFollowing($id);

        return APIHandler::response(1, "Followers", $data);

    }


    /**
     * Get the followers of the authenticated user
     * @return \App\Libraries\Response
     */
    public function authFollowers()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data['followers'] = $this->userRepository->getFollowers($currentUser['id']);
        return APIHandler::response(1, "Followers", $data);
    }

    /**
     * Get the users that the authenticated user is currently following
     * @return \App\Libraries\Response
     */
    public function authFollowing()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        // All following
        $data['following'] = $this->userRepository->getFollowing($currentUser['id']);

        return APIHandler::response(1, "Following", $data);
    }


    /**
     * Send email account verification
     * @param $id
     */
    public function sendEmailAccountVerification($id)
    {
        $user = User::findOrFail($id);
        Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
            $message->from('noreply@meetrabbi.com', 'MeetRabbi');
            $message->subject('Welcome to Meetrabbi');
            $message->to($user->email, $user->name);
        });
    }

    
    public function updateBasicProfile(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $params = $request->only(['first_name', 'account_type', 'last_name', 'name', 'location', 'about', 'gender', 'headline']);
        
        $validator = Validator::make($params, [
            'first_name' => 'string',
            'last_name' => 'string',
            'name' => 'required|string',
            'location' => 'string',
            'about' => 'string',
            'gender' => 'string',
            'headline' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $user = $this->userRepository->updateBasic($params, $currentUser['id']);

        return response()->json(['message' => 'Profile updated.', 'user' => $user]);
    }

    public function updateInterests(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $interests = $request->get('interests');
        $this->userRepository->storeInterests($currentUser['id'], $interests);
        return response()->json(['message' => 'Interest updated']);
    }
    
    public function getExpertise()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data['expertise'] = $this->mentorRepository->getExpertiseByUserId($currentUser['id']);
        return APIHandler::response(1, "User Expertise", $data);
    }

    public function isUserPasswordSet()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data['pwd_isset'] = User::where('id', $currentUser['id'])
            ->where('password', '<>', "")->exists();

        return APIHandler::response(1, "Password check", $data);
    }

    public function setPassword(Request $request)
    {
        $id = JWTAuth::parseToken()->authenticate()['id'];
        $user = User::find($id);
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return APIHandler::response(1, "Password has been set", $user);
    }

    public function updateProfilePicture(Request $request)
    {
        $id = JWTAuth::parseToken()->authenticate()['id'];
        $user = User::find($id);
        $user->avatar_uri = $request->get('profile_picture_url');
        $user->save();

        return response()->json(['message' => 'Your profile picture has been updated.']);
    }

    public function updateCoverPhoto(Request $request)
    {
        $id = JWTAuth::parseToken()->authenticate()['id'];
        $user = User::find($id);
        $user->cover_photo_url = $request->get('cover_photo_url');
        $user->save();

        return response()->json(['message' => 'Your profile picture has been updated.']);
    }
    
    public function updateEducation()
    {
        
    }
    
    public function updateExperience()
    {
        
    }

    public function getUsersWithMentorApplication()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $user = User::find($currentUser['id']);

        if (Gate::denies('get-users-with-mentor-application', $user)) {
            return response()->json(['message' => 'Unauthorized access!'], 403);
        }

        $users = $this->userRepository->fetchUserWithMentorAllApplication();

        return response()->json($users);
    }



}
