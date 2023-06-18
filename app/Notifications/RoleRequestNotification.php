<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RoleRequestNotification extends Notification
{
    use Queueable;

    private $role;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($role, $user)
    {
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Nieuwe rol aanvraag')
            ->line($this->user->name . ' heeft een nieuwe rol aangevraagd: ' . $this->role->name)
            ->action('Bekijk de aanvraag', url('/admin/role-requests'))
            ->line('Bedankt voor het gebruiken van onze applicatie!');
    }
}
