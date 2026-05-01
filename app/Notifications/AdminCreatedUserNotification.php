<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCreatedUserNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $email,
        private readonly string $password
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your CRM account has been created')
            ->view('emails.admin-created-user', [
                'name' => $notifiable->name,
                'email' => $this->email,
                'password' => $this->password,
                'loginUrl' => url('/login'),
            ]);
    }
}
