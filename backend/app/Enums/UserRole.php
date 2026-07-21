<?php

namespace App\Enums;

enum UserRole: string
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
