<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StraniceSettings extends Settings
{
    public array $kontakt_naslov;

    public array $kontakt_uvod;

    public array $pridruzi_naslov;

    public array $pridruzi_uvod;

    public array $reg_biznis_naslov;

    public array $reg_biznis_uvod;

    public array $reg_autor_naslov;

    public array $reg_autor_uvod;

    public array $prijava_naslov;

    public array $registracija_naslov;

    public array $registracija_uvod;

    public array $zaboravljena_naslov;

    public array $zaboravljena_uvod;

    public static function group(): string
    {
        return 'strane';
    }
}
