<?php

namespace App\Events;

use App\Events\Event;
use App\MentoringApplication;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MentorApplicationWasSubmitted extends Event
{
    use SerializesModels;

    public $mentorApplication;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MentoringApplication $mentoringApplication)
    {
        //
        $this->mentorApplication = $mentoringApplication;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
