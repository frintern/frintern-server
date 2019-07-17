<?php

namespace App\Http\Controllers;

use App\Events\MentorApplicationWasSubmitted;
use App\MentoringApplication;
use App\Repositories\UserExpertiseRepository;
use App\Repositories\MentoringApplicationRepository;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class MentorApplicationController extends Controller
{

    private $mentoringApplicationRepository;
    private $mentoringApplication;
    private $expertiseAreaRepository;
    private $applicationId;

    public function __construct(MentoringApplicationRepository $mentoringApplicationRepository, UserExpertiseRepository $expertiseAreaRepository)
    {
        $this->mentoringApplicationRepository = $mentoringApplicationRepository;
        $this->expertiseAreaRepository = $expertiseAreaRepository;
        $this->mentoringApplication = new MentoringApplication();
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //
        $mentoringApplications = $this->mentoringApplicationRepository->fetchAllMentoringApplications();
        return $mentoringApplications;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->only(['expertise', 'introduction', 'reason', 'mobile_number', 'notable_work_url', 'video_url']), [
            'expertise' => 'required|array',
            'introduction' => 'required|string',
            'reason' => 'required|string',
            'mobile_number' => 'required|string',
            'notable_work_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }

        // Create a new instance of mentoring application
        $application = new MentoringApplication();

        $application->user_id = $currentUser['id'];
        $application->why_mentor = $request->get('reason');
        $application->introduction = $request->get('introduction');
        $application->mobile_number = $request->get('mobile_number');
        $application->notable_work_url = $request->get('notable_work_url');
        $application->status = 0;

        $application->save();
        $this->expertiseAreaRepository->saveExpertise($request->get('expertise'), $currentUser['id']);

        $applicant = User::find($application->user_id);

        Mail::send('emails.newMentorshipApplication', ['applicant' => $applicant], function ($message) use ($applicant) {
            $message->subject('Mentorship Application Alert! :D');
            $message->priority(1);
            $message->cc('ezeanyaguuju@yahoo.com ', 'Uju Ezeanyagu');
            $message->cc('jideowosakin@gmail.com', 'Babajide Owosakin');
            $message->cc('ayoladimeji01@gmail.com', 'Ayodeji Oladimeji');
            $message->to('hello@meetrabbi.com', 'MeetRabbi Team');
            $message->from('noreply@meetrabbi.com', 'MeetRabbi Team');
            $message->to('meetrabbi@gmail.com', 'MeetRabbi Team');
        });

        Mail::send('emails.mentorApplication', ['applicant' => $applicant], function ($message) use ($applicant) {
            $message->subject('Your Mentorship Application');
            $message->priority(1);
            $message->from('noreply@meetrabbi.com', 'MeetRabbi Team');
            $message->to($applicant->email, $applicant->name);
        });

        return response()->json(['message' => "Your application has been submitted"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $user = User::find($currentUser['id']);
        if (Gate::denies('manage-mentors', $user)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $application = $this->mentoringApplicationRepository->getMentorApplicationById($id);
        return $application;
    }


    public function approve(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $user = User::find($currentUser['id']);
        $this->applicationId = $request->get('id');
        if (Gate::denies('manage-mentors', $user)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $application = MentoringApplication::find($this->applicationId);
        $application->status = 1;
        $application->save();
        $applier = User::find($application->user_id);

        $applier->is_a_mentor = 1;
        $applier->save();

        return response()->json(['message' => 'Application has been approved']);
    }

    public function decline(Request $request)
    {

        $currentUser = JWTAuth::parseToken()->authenticate();
        $this->applicationId = $request->get('id');
        $user = User::find($currentUser['id']);

        if (Gate::denies('manage-mentors', $user)) {

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $application = MentoringApplication::find($this->applicationId);

        $application->status = 3;
        $application->save();

        $applier = User::find($application->user_id);


        $applier->is_a_mentor = 0;
        $applier->save();

        return response()->json(['message' => 'Application has been declined']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
