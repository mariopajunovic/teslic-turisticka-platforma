<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Ime')->required(),
            TextInput::make('email')->email()->required(),
            TextInput::make('telefon'),
            Select::make('role')
                ->label('Uloga')
                ->options(UserRole::class)
                ->required(),
            Select::make('status')
                ->options([
                    'na_odobrenju' => 'Na odobrenju',
                    'aktivan' => 'Aktivan',
                    'blokiran' => 'Blokiran',
                ])
                ->required(),
        ]);
    }
}

