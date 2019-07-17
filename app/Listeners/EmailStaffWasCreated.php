<?php

namespace App\Listeners;

use App\Events\StaffWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailStaffWasCreated
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
     * @param  StaffWasCreated  $event
     * @return void
     */
    public function handle(StaffWasCreated $event)
    {
        //
    }
}
