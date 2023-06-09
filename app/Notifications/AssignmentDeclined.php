<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentDeclined extends Notification
{
    use Queueable;

    private $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Uw opdracht ' . $this->task->name . ' is afgewezen.')
            ->action('Bekijk hier uw openstaande opdrachten of maak een nieuwe aan.', url('/'))
            ->line('Bedankt voor het gebruiken van onze applicatie!');
    }
}
