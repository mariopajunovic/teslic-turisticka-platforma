<?php

namespace App\Filament\Resources\News\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsForm
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
                                DatePicker::make('datum')
                                    ->label('Datum vijesti'),
                                Textarea::make('izvod')
                                    ->label('Izvod')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Textarea::make('sadrzaj')
                                    ->label('Sadržaj')
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

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
                                Select::make('user_id')
                                    ->label('Autor')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload(),
                                Actions::make([
                                    Action::make('sacuvaj')
                                        ->label('Sačuvaj')
                                        ->icon('heroicon-m-check')
                                        ->keyBindings(['mod+s'])
                                        ->action(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord
                                            ? $livewire->save()
                                            : $livewire->create()),
                                ])->fullWidth(),
                            ]),

                        Section::make('Klasifikacija')
                            ->schema([
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
