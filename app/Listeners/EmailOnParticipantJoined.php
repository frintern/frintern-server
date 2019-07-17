<?php

namespace App\Listeners;

use App\Events\ParticipantJoined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailOnParticipantJoined
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
     * @param  ParticipantJoined  $event
     * @return void
     */
    public function handle(ParticipantJoined $event)
    {
        //
    }
}
