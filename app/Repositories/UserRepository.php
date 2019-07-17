<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 2/6/16
 * Time: 3:58 AM
 */

namespace App\Repositories;


use App\UserExpertise;
use App\Http\Controllers\UserController;
use App\Interest;
use App\Mentor;
use App\User;
use App\UserInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserRepository
 * @package App\Libraries
 */
class UserRepository
{


    /**
     * @var string
     */
    private $linkedAPI = "https://api.linkedin.com/v1/people/~:(id,first-name,last-name,headline,picture-url,industry,summary,specialties,positions:(id,title,summary,start-date,end-date,is-current,company:(id,name,type,size,industry,ticker)),educations:(id,school-name,field-of-study,start-date,end-date,degree,activities,notes),associations,interests,num-recommenders,date-of-birth,publications:(id,title,publisher:(name),authors:(id,name),date,url,summary),patents:(id,title,summary,number,status:(id,name),office:(name),inventors:(id,name),date,url),languages:(id,language:(name),proficiency:(level,name)),skills:(id,skill:(name)),certifications:(id,name,authority:(name),number,start-date,end-date),courses:(id,name,number),recommendations-received:(id,recommendation-type,recommendation-text,recommender),honors-awards,three-current-positions,three-past-positions,volunteer)";

    private $user;

    private $mentor;

    public function __construct()
    {
        $this->user = new User();
        $this->mentor = new Mentor();
    }
    
    public function saveNew($userData)
    {
        $this->user->account_type = $userData['accountType'];
        if ($userData['accountType'] === 'individual') {
            $this->user->first_name = $userData['firstName'];
            $this->user->last_name = $userData['lastName'];
            $this->user->name = $userData['firstName'] . ' ' . $userData['lastName'];
            $this->user->verification_code = $userData['verificationCode'];
        } else {
            $this->user->name = $userData['name'];
        }
        $this->user->username = $userData['username'];
        $this->user->email = $userData['email'];
        $this->user->password = bcrypt($userData['password']);
        $this->user->save();
        return $this->user;
    }

    /**
     * Find User by Email or create a new user from social media auth
     * @param $userData
     * @param $provider
     * @return static
     */
    public function findByEmailOrCreate($userData, $provider)
    {

        if (!is_null($userData->email)) {

            $user = User::where('email', '=', $userData->email)->first();
        } else {
            $user = User::where('username', '=', $userData->nickname)->first();
        }

        if (!$user) {
            // Create a new user account if user credentials do not exist
            $user = User::create([
                'provider_id' => $userData->id,
                'name' => $userData->name,
                'username' => $userData->nickname,
                'email' => $userData->email,
                'avatar_uri' => $userData->avatar,
                'verification_code' => str_random(30)
            ]);

            // Send verification code message

            Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
                $message->from('noreply@meetrabbi.com', 'MeetRabbi');
                $message->subject('Welcome to Meetrabbi');
                $message->to($user->email, $user->name);
            });

        }

        $this->checkIfUserNeedsUpdating($userData, $user, $provider);

        return $user;
    }

    /**
     * Check if user need updating
     * @param $userData
     * @param $provider
     * @param $user
     */
    public function checkIfUserNeedsUpdating($userData, $user, $provider)
    {

        $socialData = [
            'avatar' => $userData->avatar,
            'email' => $userData->email,
            'name' => $userData->name,
            'username' => $userData->nickname,
            'provider_id' => $userData->id,
        ];

        if ($provider == "linkedin") {
            //$data = $this->getMoreUserDataLinkedIn($userData);

            $socialData['headline'] = $userData->user['headline'];

            $socialData['about'] = "";
        } else {
            $socialData['headline'] = "Hi, I'm on Meetrabbi";
        }

        $dbData = [
            'avatar' => $user->avatar,
            'email' => $user->email,
            'name' => $user->name,
            'username' => $user->username,
            'provider_id' => $user->provider_id,
            'about' => $user->about,
            'headline' => $user->headline
        ];

        if (!empty(array_diff($socialData, $dbData))) {
            $user->avatar_uri = $userData->avatar;
            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->username = $userData->nickname;
            $user->provider_id = $userData->id;
            $user->headline = $socialData['headline'];
            $user->save();
        }
    }

    /**
     * @param $userData
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMoreUserDataLinkedIn($userData)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get($this->linkedAPI."?oauth2_access_token=".$userData->token."", ['summary']);

        $data = $response;

        return $data;
    }


    /**
     * Returns the area
     * @param $id
     * @return mixed
     */
    public function getAreasOfExpertise($id)
    {
        return DB::table('user_expertise')
            ->join('interests', 'user_expertise.interest_id', '=', 'interests.id')
            ->select('interests.*')
            ->where('user_expertise.user_id', $id)
            ->get();
    }


    public function updateBasic($params, $id)
    {
        $user = $this->user->find($id);
        
        $user->about = $params['about'];
        $user->gender = $params['gender'];
        $user->first_name = $params['first_name'];
        $user->last_name = $params['last_name'];
        $user->location = $params['location'];
        $user->name = $params['name'];
        $user->headline = $params['headline'];

        $user->save();
        
        return $user;
    }
    
    
    public function getFollowers($id)
    {
        $firstFollowers = DB::table('follows')
            ->join('users', 'follows.followed_by', '=', 'users.id')
            ->select('users.*', 'followed_by as follower_id', 'mutual')
            ->where('user_id', $id);

        // All followers
        $followers = DB::table('follows')
            ->join('users', 'follows.user_id', '=', 'users.id')
            ->select('users.*','follows.user_id as follower_id', 'mutual')
            ->where('followed_by', $id)
            ->where('follows.mutual', 1)
            ->union($firstFollowers)
            ->get();
        
        return $followers;
    }
    
    public function getFollowing($id)
    {
        // First Following
        $firstFollowing = DB::table('follows')
            ->join('users', 'follows.user_id', '=', 'users.id')
            ->select('users.*', 'user_id as following_id', 'mutual')
            ->where('followed_by', $id);


        // return all following
        return DB::table('follows')
            ->join('users', 'follows.followed_by', '=', 'users.id')
            ->select('users.*', 'followed_by as following_id', 'mutual')
            ->where('user_id', $id)
            ->where('mutual', 1)
            ->union($firstFollowing)
            ->get();
    }
    
    public function getInterests($id)
    {
        return DB::table('user_interest')
            ->join('interests', 'user_interest.interest_id', '=', 'interests.id')
            ->select('user_interest.interest_id as id', 'interests.name', 'interests.image_uri')
            ->where('user_interest.user_id', $id)
            ->get();
    }
    
    
    public function storeInterests($id, $interests)
    {

        foreach ($interests as $interest) {
            $_interest = [];
            $_interest['user_id'] = $id;
            $_interest['interest_id'] = array_has($interest, 'interest_id') ? $interest['interest_id']: $interest['id'];

            UserInterest::updateOrCreate(['id' => array_has($interest, 'id') && array_has($interest, 'interest_id') ? $interest['id']: null], $_interest);
        }
    }


    public function getUserProfileData($id, $viewerId = null)
    {
        $user = User::with(['careerPaths' => function ($query) use ($id){
            return $query->withCount(['skillGuides', 'skillProgresses' => function($query) use($id) {
                return $query->where('user_id', $id);
            }]);
        }])->where('id', $id)->first();

        return $user;
    }

    public function getUserInterests($id)
    {
         return UserInterest::join('interests', 'user_interest.interest_id', '=', 'interests.id')
            ->select('user_interest.*', 'interests.name as name')
             ->where('user_interest.user_id', $id)
            ->get();
    }

    public function getUserExpertise($id)
    {
        return UserExpertise::join('interests', 'user_expertise.interest_id', '=', 'interests.id')
            ->select('user_expertise.*', 'interests.name as name')
            ->where('user_expertise.user_id', $id)
            ->get();
    }

    public function findUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    
}