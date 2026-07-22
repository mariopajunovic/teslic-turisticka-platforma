<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IzmjeneVracene extends Notification
{
    use Queueable;

    public function __construct(public Model $content, public string $reason) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $naslov = $this->content->naslov ?? 'vaš sadržaj';

        return (new MailMessage)
            ->subject('Izmjene su vraćene na doradu')
            ->greeting('Obavijest')
            ->line("Vaše izmjene za „{$naslov}” su pregledane i vraćene na doradu.")
            ->line('Razlog: '.$this->reason)
            ->line('Trenutna objavljena verzija ostaje aktivna. Otvorite objavu u svom nalogu, ispravite izmjene i ponovo ih pošaljite na odobrenje.');
    }
}
