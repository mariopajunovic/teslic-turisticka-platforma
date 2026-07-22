<?php

namespace App\Support;

use App\Settings\SiteSettings;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as Notifications;

class OrgNotifier
{
    /** Pošalji obavijest na kontakt-email turističke organizacije (ako je postavljen). */
    public static function send(Notification $notification): void
    {
        $email = app(SiteSettings::class)->kontakt_email ?? null;

        if (filled($email)) {
            Notifications::route('mail', $email)->notify($notification);
        }
    }
}
