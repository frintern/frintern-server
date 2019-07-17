<?php

namespace App\Listeners;

use App\Events\MentorApplicationWasApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentorApplicationApproval
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
     * @param  MentorApplicationWasApproved  $event
     * @return void
     */
    public function handle(MentorApplicationWasApproved $event)
    {
        //
    }
}
