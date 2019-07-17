<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AccountWasCreated extends Event
{
    use SerializesModels;

    public $user;
    public $verificationCode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $verificationCode)
    {
        //
        $this->user = $user;
        $this->verificationCode = $verificationCode;
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
