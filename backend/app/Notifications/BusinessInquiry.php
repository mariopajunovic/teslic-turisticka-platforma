<?php

namespace App\Notifications;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BusinessInquiry extends Notification
{
    use Queueable;

    public function __construct(
        public Business $biznis,
        public array $data,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Novi upit za vaš biznis')
            ->greeting('Pozdrav!')
            ->line('Primili ste novi upit za vaš biznis „'.$this->biznis->naslov.'".')
            ->line('**Ime pošiljaoca:** '.$this->data['ime'])
            ->line('**E-mail:** '.$this->data['email'])
            ->line('**Poruka:**')
            ->line($this->data['poruka']);
    }
}
