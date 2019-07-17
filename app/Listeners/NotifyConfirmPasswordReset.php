<?php

namespace App\Listeners;

use App\Events\ConfirmResetPasswordWasTriggered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyConfirmPasswordReset
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
     * @param  ConfirmResetPasswordWasTriggered  $event
     * @return void
     */
    public function handle(ConfirmResetPasswordWasTriggered $event)
    {
        //
        Mail::send('emails.confirmPasswordReset', ['user' => $event->user, 'token' => $event->token], function($message) use ($event) {
           $message->subject('Confirm Reset Password');
           $message->priority(0);
           $message->from('noreply@meetrabbi.com', 'MeetRabbi Team');
           $message->to($event->user->email);
        });
    }
}
