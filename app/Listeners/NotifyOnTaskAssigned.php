<?php

namespace App\Listeners;

use App\Events\TaskWasAssigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyOnTaskAssigned
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
     * @param  TaskWasAssigned  $event
     * @return void
     */
    public function handle(TaskWasAssigned $event)
    {
        //
    }
}
