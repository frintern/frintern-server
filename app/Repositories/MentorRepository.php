<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/20/16
 * Time: 8:43 PM
 */

namespace App\Repositories;


use App\Interest;
use App\Mentor;
use App\MentoringApplication;
use App\User;
use App\UserExpertise;
use Illuminate\Support\Facades\DB;

class MentorRepository
{
    
    private $mentorApplication;

    private $mentor;
    
    public function __construct()
    {
        $this->mentorApplication = new MentoringApplication();
        $this->mentor = new Mentor();
    }

    public function fetchAll()
    {
        return User::with(['interests', 'expertise'])
        ->where('users.is_a_mentor', 1)
        ->where('users.account_type', 'individual')
        ->orderBy('users.created_at', 'desc')->get();
    }

    public function fetchFeaturedMentors()
    {
        return User::with(['interests', 'expertise'])
        ->where('users.is_a_mentor', 1)
        ->where('users.account_type', 'individual')
        ->orderBy('users.points', 'desc')->limit(5)->get();
    }
    
    
    public function getExpertiseByUserId($userId)
    {
        return DB::table('user_expertise')
            ->join('interests', 'user_expertise.interest_id', '=', 'interests.id')
            ->select('user_expertise.interest_id as id', 'interests.name', 'interests.image_uri')
            ->where('user_expertise.user_id', $userId)
            ->distinct()
            ->get();
    }
    
    public function getProfileByUserId($userId)
    {
        return $this->mentorApplication->select('why_mentor', 'introduction')
            ->where('user_id', $userId)
            ->first();
    }
    
    
    public function saveExpertise($userId, $expertiseArray)
    {
        foreach($expertiseArray as $expertise) {
            $_expertise = [];
            $_expertise['user_id'] = $userId;
            $_expertise['interest_id'] = array_has($expertise, 'interest_id') ? $expertise['interest_id']: $expertise['id'];
            $_expertise['rating'] = $expertise['rating'];

            UserExpertise::updateOrCreate(['id' => array_has($expertise, 'id') && array_has($expertise, 'interest_id') ? $expertise['id']: null], $_expertise);
        }
    }
    
    public function getMentorByUserId($userId)
    {
        return $this->mentor->select('*')->where('user_id', $userId)
            ->first();
    }

    /**
     * Returns the list of recommended mentors
    */
    public function getRecommendedMentors($userId)
    {
        // Get interest ids of the current user
        $interests = array_flatten(array_pluck(Interest::select('interest_id')->where('user_id', $userId)->get()->toArray(), 'interest_id'));

    }

    public function fetchMentorsYouFollow($userId)
    {
        $firstFollowing = DB::table('follows')
            ->join('users', 'follows.user_id', '=', 'users.id')
            ->select('users.*', 'user_id as following_id', 'mutual')
            ->where('followed_by', $userId)
            ->where('users.is_a_mentor', 1);

        // return all following
        return DB::table('follows')
            ->join('users', 'follows.followed_by', '=', 'users.id')
            ->select('users.*', 'followed_by as following_id', 'mutual')
            ->where('user_id', $userId)
            ->where('mutual', 1)
            ->where('users.is_a_mentor', 1)
            ->union($firstFollowing)
            ->orderBy('created_at', 'DESC')
            ->get();
    }


    public function getMentorsBySpecialization($specializationId)
    {
        $mentors = Interest::find($specializationId)
            ->mentors()->where('users.is_a_mentor', 1)->get();

        return $mentors;
    }




}