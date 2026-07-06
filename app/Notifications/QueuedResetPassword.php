<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QueuedResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('password.reset', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('Password Reset Request — Valencia Dial')
            ->greeting('Dear Valued Collector,')
            ->line('You are receiving this notification because a password reset request was submitted for your exclusive account within the Valencia Dial ecosystem.')
            ->line('To restore your credentials and regain full access to your private dashboard, please utilize the secure link below.')
            ->action('Authenticate Reset', $url)
            ->line('This cryptographic passkey will expire in a limited timeframe. If you did not authorize this request, disregard this transmission—your current credentials remain uncompromised.')
            ->salutation('— The Valencia Dial Vault Administration');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
