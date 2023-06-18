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
    private $status;
    private $user;
    public function __construct($task, $status,$user)
    {
        $this->task = $task;
        $this->status = $status;
        $this->user = $user;
    }
 
    

    public function via($notifiable)
    {
        return ['mail'];
    }

     
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('De opdracht '.$this->task->name.' is '.$this->status.' door '.$this->user->name.'.')
                    ->action('Bekijk de opdracht', url("/admin/tasks/{$this->task->id}/showTask"))
                    ->line('Bedankt voor het gebruiken van onze applicatie!');
    }
}
