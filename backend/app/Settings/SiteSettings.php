<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $brand_naziv;

    public string $brand_logo_tekst;

    public string $footer_opis;

    public string $copyright;

    public string $kontakt_adresa;

    public string $kontakt_telefon;

    public string $kontakt_email;

    public array $social;

    public array $partneri;

    public bool $google_indeksiranje;

    public bool $odrzavanje;

    public string $odrzavanje_lozinka;

    public int $odrzavanje_minuta;

    public string $odrzavanje_poruka;

    public static function group(): string
    {
        return 'site';
    }
}
