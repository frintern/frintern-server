<?php

namespace App\Events;

use App\Events\Event;
use App\Program;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InviteMenteeToProgram extends Event
{
    use SerializesModels;

    public $program;
    public $mentee;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Program $program, User $mentee)
    {
        //
        $this->program = $program;
        $this->mentee = $mentee;
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
