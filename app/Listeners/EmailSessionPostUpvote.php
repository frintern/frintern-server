<?php

namespace App\Listeners;

use App\Events\SessionPostUpvoted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSessionPostUpvote
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
     * @param  SessionPostUpvoted  $event
     * @return void
     */
    public function handle(SessionPostUpvoted $event)
    {
        //
    }
}
