<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $token
     * @return array
     */
    public function via($token)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $token
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($token)
    {
        return (new MailMessage)
                    ->line('Click the button below to recover your password')
                    ->action('RECOVERY PASSWORD', $this->token)
                    ->line('Thank you for using the Dev.ly!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $token
     * @return array
     */
    public function toArray($token)
    {
        return [
            //
        ];
    }
}
