<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\ParticipantJoined' => [
            'App\Listeners\EmailOnParticipantJoined'
        ],
        'App\Events\SessionPostWasSubmitted' => [
            'App\Listeners\NotifySessionParticipants'
        ],
        'App\Events\SessionPostUpvoted' => [
            'App\Listeners\EmailSessionPostUpvote'
        ],
        'App\Events\SessionWasCreated' => [
            'App\Listeners\NotifyPotentialParticipants'
        ],
        'App\Events\AccountWasCreated' => [
            'App\Listeners\NotifyAccountCreated'
        ],
        'App\Events\MentorApplicationWasSubmitted' => [
            'App\Listeners\NotifyMentorApplicationSubmitted'
        ],
        'App\Events\MentorApplicationWasApproved' => [
            'App\Listeners\NotifyMentorApplicationApproval'
        ],
        'App\Events\ConfirmResetPasswordWasTriggered' => [
            'App\Listeners\NotifyConfirmPasswordReset'
        ],
        'App\Events\CommentWasPosted' => [
            'App\Listeners\NotifyCommentWasPosted'
        ],
        'App\Events\InviteMentorToProgram' => [
            'App\Listeners\NotifyMentor'
        ],
        'App\Events\InviteMenteeToProgram' => [
            'App\Listeners\NotifyMentee'
        ],
        'App\Events\UserJoinedProgram' => [
            'App\Listeners\NotifyProgramCreator'
        ],
        'App\Events\QuestionWasPosted' => [
            'App\Listeners\NotifyOnQuestionPosted'
        ],
        'App\Events\ReplyWasPosted' => [
            'App\Listeners\NotifyOnReplyWasPosted'
        ],
        'App\Events\MentorWasNominated' => [
            'App\Listeners\NotifyOnMentorNominated'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
