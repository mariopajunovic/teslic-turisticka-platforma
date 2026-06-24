<?php

namespace App\Notifications;

use App\Enums\ContentStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContentStatusChanged extends Notification
{
    use Queueable;

    public function __construct(public Model $content) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $naslov = $this->content->naslov ?? 'Vaš sadržaj';

        if ($this->content->status === ContentStatus::Objavljeno) {
            return (new MailMessage)
                ->subject('Sadržaj je objavljen')
                ->greeting('Dobra vijest!')
                ->line("Vaš sadržaj „{$naslov}” je odobren i objavljen na platformi.");
        }

        return (new MailMessage)
            ->subject('Sadržaj je vraćen na doradu')
            ->greeting('Obavijest')
            ->line("Vaš sadržaj „{$naslov}” je vraćen.")
            ->line('Razlog: '.($this->content->rejection_reason ?: 'nije naveden'))
            ->line('Možete ga doraditi i ponovo poslati na odobrenje.');
    }
}
