<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrgNovaRegistracija extends Notification
{
    use Queueable;

    public function __construct(public User $user) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $uloga = $this->user->role?->getLabel() ?? (string) $this->user->role?->value;

        return (new MailMessage)
            ->subject('Nova registracija čeka odobrenje')
            ->greeting('Nova registracija')
            ->line("{$this->user->name} ({$this->user->email}) se registrovao kao: {$uloga}.")
            ->line('Nalog čeka odobrenje administratora.')
            ->action('Otvori korisnike', url('/administracija/korisnici'));
    }
}
