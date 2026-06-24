<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('naslov')
                    ->label('Naziv')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->helperText('Ostaviti prazno za automatsko generisanje.')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('category_id')
                    ->label('Kategorija')
                    ->relationship('category', 'label')
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Vlasnik')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('lokacija'),
                Textarea::make('opis')
                    ->label('Kratak opis')
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('opis_dug')
                    ->label('Detaljan opis')
                    ->rows(5)
                    ->columnSpanFull(),
                Textarea::make('kako_doci')
                    ->label('Kako doći')
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('savjeti')
                    ->label('Savjeti za posjetioce')
                    ->rows(2)
                    ->columnSpanFull(),
                TextInput::make('sezona')
                    ->label('Sezona'),
                TextInput::make('radno_vrijeme')
                    ->label('Radno vrijeme'),
                TextInput::make('ulaznice')
                    ->label('Ulaznice / cijene'),
                Fieldset::make('Lokacija na mapi')
                    ->schema([
                        TextInput::make('lat')->numeric(),
                        TextInput::make('lng')->numeric(),
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
                Toggle::make('preporuceno')
                    ->label('Izdvojeno / preporučeno'),
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
