<?php

namespace App\Events;

use App\Events\Event;
use App\MentoringSessionPost;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SessionPostWasSubmitted extends Event
{
    use SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     * @MentoringSessionPost $post
     *
     * @return void
     */
    public function __construct(MentoringSessionPost $post)
    {
        //
        $this->post = $post;
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
