<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public array $brand_naziv;

    public array $brand_logo_tekst;

    public string $brand_logo;

    public int $logo_visina;

    public array $seo_opis;

    public array $footer_opis;

    public array $copyright;

    public string $kontakt_adresa;

    public string $kontakt_telefon;

    public string $kontakt_email;

    public array $social;

    public array $partneri;

    public array $partneri_tekst;

    public bool $google_indeksiranje;

    public bool $odrzavanje;

    public string $odrzavanje_lozinka;

    public int $odrzavanje_minuta;

    public string $odrzavanje_poruka;

    public string $captcha_site_key;

    public string $captcha_secret;

    public static function group(): string
    {
        return 'site';
    }
}
