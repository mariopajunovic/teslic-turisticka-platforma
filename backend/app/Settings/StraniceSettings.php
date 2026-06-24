<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StraniceSettings extends Settings
{
    public string $kontakt_naslov;

    public string $kontakt_uvod;

    public string $pridruzi_naslov;

    public string $pridruzi_uvod;

    public string $reg_biznis_naslov;

    public string $reg_biznis_uvod;

    public string $reg_autor_naslov;

    public string $reg_autor_uvod;

    public string $prijava_naslov;

    public string $registracija_naslov;

    public string $registracija_uvod;

    public string $zaboravljena_naslov;

    public string $zaboravljena_uvod;

    public static function group(): string
    {
        return 'strane';
    }
}
