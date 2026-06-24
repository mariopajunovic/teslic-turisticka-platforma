<?php

namespace App\Filament\Resources\News\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NewsForm
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
                Select::make('user_id')
                    ->label('Autor')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
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
