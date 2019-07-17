<?php

namespace App\Listeners;

use App\Events\InviteMentorToProgram;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyMentor
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
     * @param  InviteMentorToProgram  $event
     * @return void
     */
    public function handle(InviteMentorToProgram $event)
    {
        //
        $program = $event->program;
        $creator = $program->creator;
        $mentor = $event->mentor;

        Mail::send('emails.inviteMentorToProgram', ['program' => $program, 'creator' => $creator, 'mentor' => $mentor], function ($message) use ($program, $mentor, $creator) {
            $message->subject($creator->name . " sent you an invitation.");
            $message->priority(1);
            $message->from('noreply@meetrabbi.com', $creator->name . ' via MeetRabbi');
            $message->to($mentor->email, $mentor->name);
        });
    }
}
