<?php

namespace App\Http\Controllers;

use App\Interest;
use App\UserInterest;
use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use App\Mentor;
use App\Nomination;
use App\Repositories\MentorRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Events\MentorWasNominated;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class MentorController
 * @package App\Http\Controllers
 */
class MentorController extends Controller
{
    private $userRepository;
    
    private $mentorRepository;
    //
    public function __construct(MentorRepository $mentorRepository)
    {
        $this->middleware('jwt.auth', ['except' => ['getFeaturedMentors']]);
        $this->mentorRepository = $mentorRepository;
        $this->userRepository = new UserRepository();
    }
    
    
    public function index()
    {
        return $this->mentorRepository->fetchAll();
    }


    public function getFeaturedMentors()
    {
        $featuredMentors = $this->mentorRepository->fetchFeaturedMentors();
        return $featuredMentors;
    }

    /**
     * Accept mentoring request
     * @param Request $request
     * @return $this
     */
    public function acceptMentoringRequest(Request $request)
    {
        $user = TokenHandler::decode($request->header('token'));
        $requestingUserId = $request->get('requesting_user');
        DB::table('mentoring_requests')
            ->where([['request_from', $requestingUserId], ['request_to', $user['id']]])
            ->update(['status' => 1]);

        return APIHandler::response(1, "Accepted mentoring");
    }

    /**
     * Decline mentoring request
     * @param Request $request
     * @return $this
     */
    public function declineMentoringRequest(Request $request)
    {
        $user = TokenHandler::decode($request->header('token'));
        $requestingUserId = $request->get('requesting_user');
        DB::table('mentoring_requests')
            ->where([['request_from', $requestingUserId], ['request_to', $user['id']]])
            ->update(['status' => 2]);

        return APIHandler::response(1, "Declined mentoring");
    }

    /**
     * Get mentors's mentees
     * @param Request $request
     * @return $this
     */
    public function getMyMentees(Request $request)
    {
        $user = TokenHandler::decode($request->header('token'));
        $data['mentees'] = DB::table('mentors_mentees')->where('mentor_id', $user['id'])->get();

        if (is_null($data['mentees'])) {
            return APIHandler::response(0, "You do not have mentees, Find mentees", $data);
        }

        return APIHandler::response(1, "Your mentees", $data);
    }


    /**
     * Submit mentor application
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function submitApplication(Request $request)
    {

        $currentUser = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request->only(['expertise', 'introduction', 'reason']), [
            'expertise' => 'required|array',
            'introduction' => 'required|string',
            'reason' => 'required|string'
        ]);

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), [], 400);
        }

        $mentor = new Mentor;
        $mentor->user_id = $currentUser['id'];
        $mentor->why_mentor = $request->get('reason');
        $mentor->introduction = $request->get('introduction');
        $mentor->save();
        
        $this->mentorRepository->saveExpertise($currentUser['id'], $mentor->id, $request->get('expertise'));
        UserController::becameAMentor($mentor->user_id);
        $data['mentor'] = $mentor;

        return APIHandler::response(1, "Application submitted", $data);
    }

    /**
     * Returns the list of mentors a m
     * @return \App\Libraries\Response
     */
    public function getMentorsYouFollow()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $mentorsAuthFollow = $this->mentorRepository->fetchMentorsYouFollow($currentUser['id']);

        return $mentorsAuthFollow;
    }

    /**
     * Get the mentors that match the logged in user
     * @return \App\Libraries\Response
     */
    public function getMatchedMentors()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $interests = array_flatten(array_pluck(UserInterest::select('interest_id')->where('user_id', $currentUser['id'])->get()->toArray(), 'interest_id'));

        $mentors = User::join('user_expertise', 'users.id', '=', 'user_expertise.user_id')
            ->select('users.*', 'user_expertise.interest_id')
            ->mentor()
            ->match($interests, $currentUser['id'])
            ->groupBy('users.id')
            ->get();

        return response()->json($mentors);
    }
    
    
    
    public function updateExpertise(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $expertiseArray = $request->get('expertise');
        $this->mentorRepository->saveExpertise($currentUser['id'], $expertiseArray);
        return APIHandler::response(1, "User expertise has been updated");
    }


    public function getRecommendedMentors()
    {
        $userId = JWTAuth::parseToken()->authenticate()['id'];
        $this->mentorRepository->getRecommendedMentors($userId);
    }

    public function getMentorsBySpecialization($specializationId)
    {
        $mentors = $this->mentorRepository->getMentorsBySpecialization($specializationId);
        return response()->json($mentors);
    }

    public function nominate(Request $request)
    {
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            $nomination = new Nomination();
            $nomination->user_id = $currentUser['id'];
            $nomination->nominee_email = $request->nomineeEmail;
            $nomination->note = $request->nomineeNote ? $request->nomineeNote : '';
            $nomination->save();
            event(new MentorWasNominated($nomination));
            return response()->json(['Your nominee has been notified']);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }



}
