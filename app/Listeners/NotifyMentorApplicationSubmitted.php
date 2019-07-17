<?php

namespace App\Listeners;

use App\Events\MentorApplicationWasSubmitted;
use App\MentoringApplication;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyMentorApplicationSubmitted implements ShouldQueue
{

    private $admin = 'meetrabbi@gmail.com';

    /**
     * Handle the event.
     *
     * @param  MentorApplicationWasSubmitted  $event
     * @return void
     */
    public function handle(MentorApplicationWasSubmitted $event)
    {
        //
        $application = $event->mentorApplication;
        $applicant = $application->user();

        $this->notifyApplicant($applicant);
        $this->notifyAdmin($applicant);
    }


    public function notifyAdmin ($applicant)
    {
        Mail::send('emails.newMentorshipApplication', ['applicant' => $applicant], function ($message) use ($applicant) {
            $message->subject('A New Mentorship Application');
            $message->priority(1);
            $message->cc('tolu@meetrabbi.com', 'Toluwanimi Ajewole');
            $message->cc('jideowosakin@gmail.com', 'Toluwanimi Ajewole');
            $message->cc('ayodeji.trevo@gmail.com', 'Babajide Owosakin');
            $message->to('hello@meetrabbi.com', 'MeetRabbi Team');
            $message->from('noreply@meetrabbi.com', 'MeetRabbi');
            $message->to($this->admin, 'MeetRabbi Team');
        });
    }


    public function notifyApplicant ($applicant)
    {
        Mail::send('emails.mentorApplication', ['applicant' => $applicant], function ($message) use ($applicant) {
            $message->subject('Your Mentorship Application');
            $message->priority(1);
            $message->from('noreply@meetrabbi.com', 'MeetRabbi');
            $message->to($applicant->email, $applicant->name);
        });
    }
}
