<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Reset Your Password')
        ->greeting('Hello!')
        ->line('You are receiving this email because we received a password reset request for your account.')
        ->action('Reset Password', route('password.reset', $this->token))
        ->line('If you did not request a password reset, no further action is required.')
        ->salutation('Regards, ' . config('app.name'));
}

}
