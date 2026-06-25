<?php

namespace App\Filament\Resources\Stories\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StoryForm
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
                                TextInput::make('autor')
                                    ->label('Autor (prikaz)'),
                                DatePicker::make('datum')
                                    ->label('Datum'),
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

                        Section::make('Autor')
                            ->schema([
                                Textarea::make('autor_bio')
                                    ->label('Bio autora')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
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
                                Toggle::make('featured')
                                    ->label('Izdvojeno / featured'),
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
                                Select::make('category_id')
                                    ->label('Kategorija')
                                    ->relationship('category', 'label')
                                    ->searchable()
                                    ->preload(),
                                Select::make('user_id')
                                    ->label('Autor (nalog)')
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
