<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminLozinkaLink extends Notification
{
    use Queueable;

    public function __construct(
        public string $token,
        public bool $noviNalog = false,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/administracija/lozinka/'.$this->token.'?email='.urlencode($notifiable->getEmailForPasswordReset()));

        if ($this->noviNalog) {
            return (new MailMessage)
                ->subject('Postavite lozinku za administratorski nalog')
                ->greeting('Zdravo!')
                ->line('Kreiran je administratorski nalog za TO Teslić. Postavite svoju lozinku klikom na dugme ispod.')
                ->action('Postavi lozinku', $url)
                ->line('Ako niste očekivali ovaj email, slobodno ga ignorišite.');
        }

        return (new MailMessage)
            ->subject('Reset lozinke administratorskog naloga')
            ->greeting('Zdravo!')
            ->line('Zatražen je reset lozinke za vaš administratorski nalog.')
            ->action('Resetuj lozinku', $url)
            ->line('Ako niste vi zatražili reset, slobodno ignorišite ovaj email.');
    }
}
