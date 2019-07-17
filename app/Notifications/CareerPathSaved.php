<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class CareerPathSaved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($careerFitData)
    {
        $this->careerFitData = $careerFitData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        $careerFitData = $this->careerFitData;
        return (new SlackMessage)
        ->success()
        ->content(":trumpet: A new learner has joined :dancer: :books:")
        ->attachment(function ($attachment) use ($careerFitData) {
            $attachment->fields([
                'Name' => $careerFitData['fullName'],
                'Career fits' => $careerFitData['careerFits'],
                'Email' => $careerFitData['email'],
                'WhatsApp Number' => $careerFitData['whatsAppNumber'],
                'Manage Score' => $careerFitData['score']['manage'],
                'Design Score' => $careerFitData['score']['design'],
                'Analyze Score' => $careerFitData['score']['analyze'],
            ]);
        });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Title',
            'description' => 'Description'
        ];
    }
}
