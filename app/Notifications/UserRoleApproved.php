<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRoleApproved extends Notification
{
    use Queueable;

    public $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Je rol aanvraag voor ' . $this->role->name . ' is goedgekeurd.')
                    ->action('Bekijk je profiel', url('/profile'))
                    ->line('Bedankt voor het gebruik van onze applicatie!');
    }
}
