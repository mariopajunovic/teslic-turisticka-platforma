<?php

namespace App\Filament\Resources\Ads\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // ── Glavni stub ──────────────────────────────────────────
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make('Osnovno')
                            ->schema([
                                TextInput::make('naslov')
                                    ->label('Naslov')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->helperText('Ostaviti prazno za automatsko generisanje.')
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
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
                            ])
                            ->columns(2),

                        Section::make('Kontakt')
                            ->schema([
                                TextInput::make('kontakt.osoba')->label('Osoba za kontakt'),
                                TextInput::make('kontakt.telefon')->label('Telefon'),
                                TextInput::make('kontakt.email')->label('E-mail')->email(),
                            ])
                            ->columns(2)
                            ->collapsible(),

                        Section::make('Galerija')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('galerija')
                                    ->hiddenLabel()
                                    ->collection('galerija')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),
                    ]),

                // ── Bočni panel ──────────────────────────────────────────
                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Objavljivanje')
                            ->schema([
                                Select::make('status')
                                    ->options(ContentStatus::class)
                                    ->default('nacrt')
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->label('Objavljeno'),
                            ]),

                        Section::make('Klasifikacija')
                            ->schema([
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
                                Select::make('tags')
                                    ->label('Oznake')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                    ]),
                            ]),

                        Section::make('Naslovna slika')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('naslovna')
                                    ->hiddenLabel()
                                    ->collection('naslovna')
                                    ->image()
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
