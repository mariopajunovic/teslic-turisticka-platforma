<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case Biznis = 'biznis';
    case Autor = 'autor';

    public function getLabel(): string
    {
        return match ($this) {
            self::Biznis => 'Biznis korisnik',
            self::Autor => 'Autor',
        };
    }
}
