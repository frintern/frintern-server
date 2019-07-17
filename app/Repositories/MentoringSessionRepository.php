<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 8/31/16
 * Time: 5:19 AM
 */

namespace App\Repositories;


use App\Interest;
use App\MentoringSession;
use App\MentoringSessionParticipant;
use App\Tag;
use App\Taggable;
use App\UserInterest;
use Illuminate\Support\Facades\DB;

class MentoringSessionRepository
{

    private $tagRepository;


    public function __construct ()
    {
        $this->tagRepository = new TagRepository();
    }


    public function getMentoringSessionsByInterests($userId = null)
    {

        $interests = array_flatten(array_pluck(UserInterest::select('interest_id')->where('user_id', $userId)->get()->toArray(), 'interest_id'));

//        $mentoringSessions = MentoringSession::with(['mentoringArea', 'creator', 'participants', 'posts'])->whereIn('mentoring_area_id', $interests)->orderBy('created_at', 'DESC')->get();
        $mentoringSessions = MentoringSession::with(['interest', 'creator', 'participants', 'posts'])->orderBy('start_time', 'DESC')->get();

        return $mentoringSessions;

    }

    public function createOrUpdate ($mentoringSessionData, $id = null)
    {
        $mentoringSession = MentoringSession::updateOrCreate(['id' => $id], $mentoringSessionData);

        $mentoringSession->start_time = $mentoringSessionData['start_time'];
        $mentoringSession->end_time = $mentoringSessionData['end_time'];
        $mentoringSession->save();

        $this->tagRepository->addTags($mentoringSession->id, 'App\MentoringSession', $mentoringSessionData['tags']);

        // Register the creator of the mentoring session as the first participant
        $this->addParticipant($mentoringSession->user_id, $mentoringSession->id);

        return $mentoringSession;

    }

    public function fetchMentoringSessionDetails($id, $currentUserId = null)
    {
        $mentoringSession = MentoringSession::with([
            'creator',

            'participants' => function ($q) {

            return $q->with('user')->orderBy('created_at', 'DESC');
        },
            'posts' => function ($q){

                return $q->with('author', 'upvotes', 'replies')->orderBy('created_at', 'DESC');

            },

            'tags'])->where('id', $id)->first();


        $mentoringSession->allow_user_participate = MentoringSessionParticipant::where('user_id', $currentUserId)->where('mentoring_session_id', $id)->exists();


        return $mentoringSession;

    }

    public function addParticipant($userId, $mentoringSessionId)
    {
        $participant = new MentoringSessionParticipant();

        $participant->user_id = $userId;
        $participant->mentoring_session_id = $mentoringSessionId;
        $participant->status = 1;
        $participant->updated_at = $participant->created_at = \Carbon\Carbon::now();
        $participant->save();

        return $participant;
    }

    public function fetchUpcomingSessions($userId)
    {

        $interests = array_flatten(array_pluck(UserInterest::select('interest_id')->where('user_id', $userId)->get()->toArray(), 'interest_id'));

        return MentoringSession::with(['interest', 'creator'])->upcoming()->orderBy('created_at', 'DESC')->limit(5)->get();

    }






}