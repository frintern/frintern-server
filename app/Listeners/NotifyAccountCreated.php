<?php

namespace App\Listeners;

use App\Events\AccountWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAccountCreated
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
     * @param  AccountWasCreated  $event
     * @return void
     */
    public function handle(AccountWasCreated $event)
    {
        //
        $user = $event->user;
        $verificationCode = $event->verificationCode;

        Mail::send('emails.welcome', ['user' => $user, 'verificationCode' => $verificationCode], function ($message) use ($user) {
            $message->subject('Activate your account at Frintern');
            $message->priority(1);
            $message->to($user->email, $user->name);
            $message->from('noreply@frintern.com', 'Frintern');
        });
    }
}
