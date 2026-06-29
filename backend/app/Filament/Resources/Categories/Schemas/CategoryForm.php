<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                Textarea::make('opis')
                    ->label('Uvodni tekst')
                    ->rows(3)
                    ->helperText('Prikazuje se na vrhu kategorijske stranice, ispod hero bloka.'),
                FileUpload::make('hero_image')
                    ->label('Hero slika')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->helperText('Naslovna slika kategorijske stranice. Ako je prazno, koristi se podrazumijevana slika sekcije.'),
                TextInput::make('meta_title')
                    ->label('SEO naslov')
                    ->helperText('Ako je prazno, koristi se naziv kategorije.'),
                Textarea::make('meta_description')
                    ->label('SEO opis')
                    ->rows(2),
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
