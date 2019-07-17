<?php

namespace App\Listeners;

use App\Events\CommentWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyCommentWasPosted
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
     * @param  CommentWasPosted  $event
     * @return void
     */
    public function handle(CommentWasPosted $event)
    {
        //
        $authorOfComment = $event->comment->author;
        $authorOfPost = $event->comment->resource->user;
        $post = $event->comment->resource;

        Mail::send('emails.commentWasPosted', ['authorOfComment' => $authorOfComment, 'authorOfPost' => $authorOfPost, 'post' => $post], function($message) use ($authorOfComment, $authorOfPost){
            $message->subject($authorOfComment->name . " wrote a comment on your post");
            $message->priority(0);
            $message->from('noreply@meetrabbi.com', $authorOfPost->first_name . " " . $authorOfPost->last_name);
            $message->to($authorOfPost->email);
        });
    }
}
