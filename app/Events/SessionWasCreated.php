<?php

namespace App\Events;

use App\Events\Event;
use App\MentoringSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SessionWasCreated extends Event
{
    use SerializesModels;

    public $mentoringSession;

    /**
     * Create a new event instance.
     * @param MentoringSession $mentoringSession
     * @return void
     */
    public function __construct(MentoringSession $mentoringSession)
    {
        //
        $this->mentoringSession = $mentoringSession;
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
