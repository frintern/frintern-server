<?php

namespace App\Events;

use App\Events\Event;
use App\Program;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InviteMentorToProgram extends Event
{
    use SerializesModels;

    public $program;
    public $mentor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Program $program, User $mentor)
    {
        //
        $this->program = $program;
        $this->mentor = $mentor;
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
