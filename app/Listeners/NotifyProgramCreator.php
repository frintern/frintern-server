<?php

namespace App\Listeners;

use App\Events\UserJoinedProgram;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyProgramCreator
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
     * @param  UserJoinedProgram  $event
     * @return void
     */
    public function handle(UserJoinedProgram $event)
    {
        //
        $program = $event->program;
        $invitee = $event->invitee;

        Mail::send('emails.userJoinedProgram', ['program' => $program, 'invitee' => $invitee], function ($message) use ($program, $invitee) {
            $message->subject($invitee->name . " has joined your learning path.");
            $message->priority(1);
            $message->from('noreply@meetrabbi.com', $invitee->name . ' via MeetRabbi');
            $message->to($program->creator->email, $program->creator->name);
        });


    }
}
