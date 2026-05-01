<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset your CRM password')
            ->view('emails.reset-password', [
                'name' => $notifiable->name,
                'email' => $notifiable->getEmailForPasswordReset(),
                'resetUrl' => $resetUrl,
                'expireMinutes' => config('auth.passwords.users.expire', 60),
            ]);
    }
}
