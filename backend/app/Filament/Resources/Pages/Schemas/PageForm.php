<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Blocks\PageBlocks;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Stranica')
                ->schema([
                    TextInput::make('title')
                        ->label('Naslov')
                        ->required(),
                    TextInput::make('slug')
                        ->helperText('Ostaviti prazno za automatsko generisanje. Sistemske stranice imaju zaključan slug.')
                        ->unique(ignoreRecord: true)
                        ->disabled(fn ($record) => (bool) ($record?->is_system)),
                    Toggle::make('published')
                        ->label('Objavljeno')
                        ->default(true),
                    TextInput::make('meta_title')->label('SEO naslov'),
                    Textarea::make('meta_description')->label('SEO opis')->rows(2),
                ])
                ->columns(2),

            Builder::make('content')
                ->label('Sadržaj (blokovi)')
                ->blocks(PageBlocks::all())
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }
}
