<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KorisnikLozinkaLink extends Notification
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
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        if ($this->noviNalog) {
            return (new MailMessage)
                ->subject('Dobrodošli - postavite lozinku za svoj nalog')
                ->greeting('Zdravo!')
                ->line('Kreiran je nalog za vas na portalu Turističke organizacije Grada Teslić. Postavite svoju lozinku klikom na dugme ispod.')
                ->action('Postavi lozinku', $url)
                ->line('Ako niste očekivali ovaj email, slobodno ga ignorišite.')
                ->salutation('Srdačan pozdrav, Turistička organizacija Grada Teslić');
        }

        return (new MailMessage)
            ->subject('Reset lozinke - Turistička organizacija Grada Teslić')
            ->greeting('Zdravo!')
            ->line('Zatražen je reset lozinke za vaš nalog na portalu Turističke organizacije Grada Teslić.')
            ->action('Postavi novu lozinku', $url)
            ->line('Link vrijedi 60 minuta.')
            ->line('Ako niste vi zatražili reset, slobodno ignorišite ovaj email - vaša lozinka ostaje nepromijenjena.')
            ->salutation('Srdačan pozdrav, Turistička organizacija Grada Teslić');
    }
}
