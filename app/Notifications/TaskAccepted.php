<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAccepted extends Notification
{
    use Queueable;

    private $task;

    public function __construct($task, $status)
    {
        $this->task = $task;
        $this->status = $status;
    }
 
    

    public function via($notifiable)
    {
        return ['mail'];
    }

     
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('De opdracht '.$this->task->name.' is '.$this->status.'.')
                ->action('Bekijk de opdracht', url('/'))
                    ->line('Bedankt voor het gebruiken van onze applicatie!');
    }
}
