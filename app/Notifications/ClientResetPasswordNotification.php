<?php
namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = clientUrl("password/reset/{$this->token}?email={$notifiable->email}");

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->markdown('emails.client.reset-password', ['url' => $url]);

    }
}
