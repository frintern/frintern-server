<?php

namespace App\Listeners;

use App\Events\MentorWasNominated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyOnMentorNominated
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
     * @param  MentorWasNominated  $event
     * @return void
     */
    public function handle(MentorWasNominated $event)
    {
        //
        $nominator = $event->nomination->nominator;
        $nomination = $event->nomination;

        Mail::send('emails.nominateMentor', ['nominator' => $nominator, 'nomination' => $event->nomination], function($message) use ($nominator, $nomination){
            $message->subject('Congratulations! You have been nominated!');
            $message->priority(0);
            $message->from('noreply@meetrabbi.com', $nominator->first_name . " " . $nominator->last_name . " - MeetRabbi");
            $message->to($nomination->nominee_email);
        });
    }
}
