<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ContentStatus: string implements HasLabel, HasColor
{
    case Nacrt = 'nacrt';
    case Poslano = 'poslano';
    case Odobreno = 'odobreno';
    case Objavljeno = 'objavljeno';
    case Odbijeno = 'odbijeno';
    case Arhivirano = 'arhivirano';

    public function getLabel(): string
    {
        return match ($this) {
            self::Nacrt => 'Nacrt',
            self::Poslano => 'Poslano na odobrenje',
            self::Odobreno => 'Odobreno',
            self::Objavljeno => 'Objavljeno',
            self::Odbijeno => 'Odbijeno',
            self::Arhivirano => 'Arhivirano',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Nacrt => 'gray',
            self::Poslano => 'warning',
            self::Odobreno => 'info',
            self::Objavljeno => 'success',
            self::Odbijeno => 'danger',
            self::Arhivirano => 'gray',
        };
    }
}
