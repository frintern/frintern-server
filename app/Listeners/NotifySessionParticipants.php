<?php

namespace App\Listeners;

use App\Events\SessionPostWasSubmitted;
use App\MentoringSession;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifySessionParticipants
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SessionPostWasSubmitted  $event
     * @return void
     */
    public function handle(SessionPostWasSubmitted $event)
    {
        //
        $post = $event->post;
        $session = MentoringSession::with('participants')->where('mentoring_sessions.id', $post->mentoring_session_id)->whereNotIn('mentoring_session_participants.user_id', [$post->user_id])->get();
        $participants = $session->participants;

        foreach ($participants as $participant) {
            Mail::send('email.mentoringPostAlert', ['post' => $post, 'session' => $session, 'participant' => $participant], function ($message) use ($post, $session, $participant) {
                $message->to($participant->name, $participant->email);
            });
        }
    }
}
