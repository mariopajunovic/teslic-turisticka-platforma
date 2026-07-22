<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrgNovaPoruka extends Notification
{
    use Queueable;

    public function __construct(
        public string $ime,
        public string $email,
        public string $poruka,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nova poruka sa sajta')
            ->greeting('Nova poruka')
            ->line("Od: {$this->ime} ({$this->email})")
            ->line('Poruka:')
            ->line($this->poruka)
            ->replyTo($this->email, $this->ime);
    }
}
