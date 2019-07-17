<?php

namespace App\Http\Controllers;

use App\Events\Event;
use App\Events\SessionWasCreated;
use App\MentoringSession;
use App\Repositories\MentoringSessionRepository;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class MentoringSessionController extends Controller
{

    public $mentoringSession;
    public $mentoringSessionRepository;


    public function __construct(MentoringSessionRepository $mentoringSessionRepository)
    {
        $this->mentoringSessionRepository = $mentoringSessionRepository;
        $this->mentoringSession = new MentoringSession();
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            $mentoringSessions = $this->mentoringSessionRepository->getMentoringSessionsByInterests($currentUser['id']);

        } catch (JWTException $ex) {
            $mentoringSessions = $this->mentoringSessionRepository->getMentoringSessionsByInterests();
        }
        return $mentoringSessions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $mentoringSessionData = $request->only(['interest_id', 'topic', 'description', 'start_time', 'end_time', 'tags']);
        $mentoringSessionData['user_id'] = $currentUser['id'];
        $validator = $this->mentoringSession->validate($mentoringSessionData);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }

        $mentoringSession = $this->mentoringSessionRepository->createOrUpdate($mentoringSessionData);

        // Notify user with the mentoring areas
//        Event::fire(new SessionWasCreated($mentoringSession));

        return response()->json(compact('mentoringSession'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $currentUserId = JWTAuth::parseToken()->authenticate()['id'];
            $mentoringSession = $this->mentoringSessionRepository->fetchMentoringSessionDetails($id, $currentUserId);
        } catch(JWTException $ex) {
            // returns the mentoring session but user won't be able to participate
            $mentoringSession = $this->mentoringSessionRepository->fetchMentoringSessionDetails($id, null);
        }

        return response()->json(compact('mentoringSession'));
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
        $currentUser = JWTAuth::parseToken()->authenticate();
        $mentoringSessionData = $request->only(['interest_id', 'topic', 'description', 'image_url']);
        $mentoringSessionData['user_id'] = $currentUser['id'];
        $validator = $this->mentoringSession->validate($mentoringSessionData);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $mentoringSession = $this->mentoringSessionRepository->createOrUpdate($mentoringSessionData, $id);
        return response()->json(compact('mentoringSession'));
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


    public function join(Request $request)
    {
        $currentUserId = JWTAuth::parseToken()->authenticate()['id'];
        $_participant = User::find($currentUserId);
        $mentoringSessionId = $request->get('id');
        $participant = $this->mentoringSessionRepository->addParticipant($currentUserId, $mentoringSessionId);
        $session = $this->mentoringSessionRepository->fetchMentoringSessionDetails($mentoringSessionId, $currentUserId);
        Mail::send('emails.joinedMentoringSession', ['participant' => $_participant, 'session' => $session], function ($message) use ($_participant, $session) {
            $message->subject($_participant->name .' joined your mentoring session - ' . $session->topic);
            $message->priority(1);
            $message->from('noreply@meetrabbi.com', 'MeetRabbi');
            $message->to($session->creator->email, $session->creator->name);
        });

        return response()->json($participant, 200);
    }


    public function upcomingMentoringSessions()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $upcomingSessions = $this->mentoringSessionRepository->fetchUpcomingSessions($currentUser['id']);

        return $upcomingSessions;
    }
}
