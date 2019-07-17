<?php

namespace App\Events;

use App\Events\Event;
use App\Program;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserJoinedProgram extends Event
{
    use SerializesModels;

    public $program;
    public $invitee;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Program $program, User $invitee)
    {
        //
        $this->program = $program;
        $this->invitee = $invitee;
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
