<?php

namespace App\Filament\Resources\Ads\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class AdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('naslov')
                    ->label('Naslov')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->helperText('Ostaviti prazno za automatsko generisanje.')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('category_id')
                    ->label('Vrsta')
                    ->relationship('category', 'label')
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Korisnik')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('izdavac')
                    ->label('Izdavač'),
                TextInput::make('lokacija')
                    ->label('Lokacija'),
                DatePicker::make('rok')
                    ->label('Rok važenja'),
                Textarea::make('opis_dug')
                    ->label('Detaljan opis')
                    ->rows(5)
                    ->columnSpanFull(),
                Fieldset::make('Kontakt')
                    ->schema([
                        TextInput::make('kontakt.osoba')->label('Osoba za kontakt'),
                        TextInput::make('kontakt.telefon')->label('Telefon'),
                        TextInput::make('kontakt.email')->label('E-mail')->email(),
                    ]),
                SpatieMediaLibraryFileUpload::make('naslovna')
                    ->label('Naslovna slika')
                    ->collection('naslovna')
                    ->image(),
                SpatieMediaLibraryFileUpload::make('galerija')
                    ->collection('galerija')
                    ->image()
                    ->multiple()
                    ->reorderable(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('nacrt')
                    ->required(),
                DateTimePicker::make('published_at')
                    ->label('Objavljeno'),
                Select::make('tags')
                    ->label('Oznake')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                    ]),
            ]);
    }
}
