<?php

namespace App\Listeners;

use App\Events\ReplyWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyOnReplyWasPosted
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
     * @param  ReplyWasPosted  $event
     * @return void
     */
    public function handle(ReplyWasPosted $event)
    {
        $reply = $event->reply;
        $author = $event->reply->author;
        $question = $event->reply->question;
        $questionAuthor = $question->author;
        $directedTo = $question->directedTo;

        if ($reply->user_id !== $question->asked_by) {
            // Send mail to the questioner
            Mail::send('emails.replyToQuestioner', 
            ['reply' => $reply, 'author' => $author, 'questionAuthor' => $questionAuthor, 'question' => $question], 
            function($message) use ($author, $questionAuthor) {
                $message->subject($author->name . " posted a reply");
                $message->priority(0);
                $message->from('noreply@meetrabbi.com', $author->first_name . " " . $author->last_name . " - MeetRabbi");
                $message->to($questionAuthor->email);
            });
        } else if ($reply->user_id === $question->asked_by) {
            // Send mail to the person that needs to answer the question
            Mail::send('emails.replyToDirectedTo', 
            ['reply' => $reply, 'author' => $author, 'directedTo' => $directedTo, 'question' => $question], 
            function($message) use ($author, $directedTo) {
                $message->subject($author->name . " posted a reply");
                $message->priority(0);
                $message->from('noreply@meetrabbi.com', $author->first_name . " " . $author->last_name . " - MeetRabbi");
                $message->to($directedTo->email);
            });
        }
    }
}
