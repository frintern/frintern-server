<?php

namespace App\Listeners;

use App\Events\InviteMenteeToProgram;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyMentee
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
     * @param  InviteMenteeToProgram  $event
     * @return void
     */
    public function handle(InviteMenteeToProgram $event)
    {
        //
        $program = $event->program;
        $creator = $program->creator;
        $mentee = $event->mentee;

        Mail::send('emails.inviteMenteeToProgram', ['program' => $program, 'creator' => $creator, 'mentee' => $mentee], function ($message) use ($program, $mentee, $creator) {
            $message->subject($creator->name . " sent you an invitation.");
            $message->priority(1);
            $message->from('noreply@meetrabbi.com', $creator->name . ' via MeetRabbi');
            $message->to($mentee->email, $mentee->name);
        });
    }
}
