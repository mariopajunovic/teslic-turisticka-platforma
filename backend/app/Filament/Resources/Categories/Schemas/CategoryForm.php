<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('icon')
                    ->helperText('Lucide naziv ikone (npr. zanat, hrana, leaf, calendar) — koristi se u legendi i na pinu mape.'),
                ColorPicker::make('color')
                    ->helperText('Boja kategorije (pin na mapi + swatch u legendi).'),
                TextInput::make('type'),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
