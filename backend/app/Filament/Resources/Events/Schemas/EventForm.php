<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventForm
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
                            ->description('Naziv, lokacija, termin i opis događaja.')
                            ->schema([
                                TextInput::make('naslov')
                                    ->label('Naziv')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->helperText('Ostaviti prazno za automatsko generisanje.')
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('lokacija')
                                    ->label('Lokacija'),
                                TextInput::make('organizator')
                                    ->label('Organizator'),
                                DatePicker::make('datum')
                                    ->label('Datum'),
                                TextInput::make('vrijeme')
                                    ->label('Vrijeme'),
                                Textarea::make('opis')
                                    ->label('Kratak opis')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Textarea::make('opis_dug')
                                    ->label('Detaljan opis')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Section::make('Lokacija na mapi')
                            ->schema([
                                TextInput::make('lat')->numeric(),
                                TextInput::make('lng')->numeric(),
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
                                    ->label('Status')
                                    ->options(ContentStatus::class)
                                    ->default('nacrt')
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->label('Objavljeno'),
                                Toggle::make('zavrseno')
                                    ->label('Završeno'),
                            ]),

                        Section::make('Klasifikacija')
                            ->schema([
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
