<?php

namespace App\Listeners;

use App\Events\SessionWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyPotentialParticipants
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
     * @param  SessionWasCreated  $event
     * @return void
     */
    public function handle(SessionWasCreated $event)
    {
        //
    }
}
