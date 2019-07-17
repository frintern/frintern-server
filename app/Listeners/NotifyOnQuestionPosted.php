<?php

namespace App\Listeners;

use App\Events\QuestionWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyOnQuestionPosted
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
     * @param  QuestionWasPosted  $event
     * @return void
     */
    public function handle(QuestionWasPosted $event)
    {
        $author = $event->question->author;
        $directedTo = $event->question->directedTo;
        $question = $event->question;

        Mail::send('emails.questionWasPosted', ['author' => $author, 'directedTo' => $directedTo, 'question' => $question], function($message) use ($author, $directedTo){
            $message->subject($author->name . " asked you a question");
            $message->priority(0);
            $message->from('noreply@meetrabbi.com', $author->first_name . " " . $author->last_name . " - MeetRabbi");
            $message->to($directedTo->email);
        });
    }
}
