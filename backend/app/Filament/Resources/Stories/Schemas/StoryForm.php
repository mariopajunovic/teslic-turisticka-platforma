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
use Filament\Schemas\Schema;

class StoryForm
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
                    ->label('Kategorija')
                    ->relationship('category', 'label')
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Autor (nalog)')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
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
                Textarea::make('autor_bio')
                    ->label('Bio autora')
                    ->rows(3)
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
                Toggle::make('featured')
                    ->label('Izdvojeno / featured'),
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
