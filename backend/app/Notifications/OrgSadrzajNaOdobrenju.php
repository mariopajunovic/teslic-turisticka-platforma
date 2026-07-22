<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrgSadrzajNaOdobrenju extends Notification
{
    use Queueable;

    public function __construct(
        public string $tip,
        public string $naslov,
        public string $ko,
        public bool $izmjena = false,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $sta = $this->izmjena ? 'Izmjena postojećeg sadržaja' : 'Novi sadržaj';

        return (new MailMessage)
            ->subject($sta.' čeka odobrenje')
            ->greeting($sta)
            ->line("{$this->tip}: „{$this->naslov}” od {$this->ko} čeka pregled i odobrenje.")
            ->action('Otvori red odobravanja', url('/administracija'));
    }
}
