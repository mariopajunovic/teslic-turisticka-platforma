<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Naziv')
                    ->required(),
                TextInput::make('key')
                    ->label('Ključ')
                    ->helperText('Tehnički identifikator (npr. main, footer_brzi).')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }
}
