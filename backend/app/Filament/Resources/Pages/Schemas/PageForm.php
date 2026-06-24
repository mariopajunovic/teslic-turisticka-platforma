<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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
                        ->helperText('Ostaviti prazno za automatsko generisanje.')
                        ->unique(ignoreRecord: true),
                    Toggle::make('published')
                        ->label('Objavljeno')
                        ->default(true),
                    TextInput::make('meta_title')->label('SEO naslov'),
                    Textarea::make('meta_description')->label('SEO opis')->rows(2),
                ])
                ->columns(2),

            Builder::make('content')
                ->label('Sadržaj (blokovi)')
                ->blocks([
                    Builder\Block::make('hero')
                        ->label('Hero')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            TextInput::make('kicker')->label('Nadnaslov'),
                            TextInput::make('title')->label('Naslov')->required(),
                            Textarea::make('subtitle')->label('Podnaslov')->rows(2),
                            TextInput::make('image')->label('Slika (URL)'),
                            Select::make('variant')
                                ->label('Varijanta')
                                ->options([
                                    'split' => 'Split',
                                    'slika-pozadina' => 'Slika u pozadini',
                                ])
                                ->default('split'),
                        ]),

                    Builder\Block::make('section_header')
                        ->label('Naslov sekcije')
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            TextInput::make('title')->label('Naslov')->required(),
                            TextInput::make('linkText')->label('Tekst linka'),
                            TextInput::make('to')->label('Link'),
                        ]),

                    Builder\Block::make('rich_text')
                        ->label('Tekst')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            RichEditor::make('sadrzaj')->label('Sadržaj'),
                        ]),

                    Builder\Block::make('card_grid')
                        ->label('Mreža kartica')
                        ->icon('heroicon-o-squares-2x2')
                        ->schema([
                            TextInput::make('naslov')->label('Naslov sekcije'),
                            Select::make('resource')
                                ->label('Izvor')
                                ->options([
                                    'business' => 'Biznisi',
                                    'location' => 'Lokaliteti',
                                    'event' => 'Događaji',
                                    'ad' => 'Oglasi',
                                    'story' => 'Priče',
                                ])
                                ->default('business')
                                ->required(),
                            TextInput::make('kategorija')->label('Kategorija (ključ, opciono)'),
                            TextInput::make('limit')->label('Broj kartica')->numeric()->default(8),
                            Select::make('cols')
                                ->label('Kolona')
                                ->options([3 => '3', 4 => '4'])
                                ->default(4),
                            TextInput::make('linkText')->label('Tekst linka'),
                            TextInput::make('to')->label('Link'),
                        ]),

                    Builder\Block::make('cta')
                        ->label('Poziv na akciju (CTA)')
                        ->icon('heroicon-o-megaphone')
                        ->schema([
                            TextInput::make('title')->label('Naslov')->required(),
                            Textarea::make('text')->label('Tekst')->rows(2),
                            Repeater::make('buttons')
                                ->label('Dugmad')
                                ->schema([
                                    TextInput::make('label')->label('Tekst')->required(),
                                    TextInput::make('url')->label('Link')->required(),
                                    Select::make('variant')
                                        ->options([
                                            'sekundarna' => 'Sekundarna',
                                            'primary' => 'Primarna',
                                        ])
                                        ->default('sekundarna'),
                                ])
                                ->columns(3),
                        ]),

                    Builder\Block::make('category_nav')
                        ->label('Navigacija kategorija')
                        ->icon('heroicon-o-squares-plus')
                        ->schema([
                            Repeater::make('items')
                                ->label('Stavke')
                                ->schema([
                                    TextInput::make('label')->label('Naziv')->required(),
                                    TextInput::make('icon')->label('Ikona')->default('tag'),
                                    TextInput::make('to')->label('Link')->required(),
                                ])
                                ->columns(3),
                        ]),

                    Builder\Block::make('gallery')
                        ->label('Galerija')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            TextInput::make('naslov')->label('Naslov sekcije'),
                            Select::make('variant')
                                ->options(['grid' => 'Mreža', 'carousel' => 'Karusel'])
                                ->default('grid'),
                            Repeater::make('items')
                                ->label('Slike')
                                ->schema([
                                    TextInput::make('src')->label('URL slike')->required(),
                                    TextInput::make('alt')->label('Opis'),
                                ])
                                ->columns(2),
                        ]),

                    Builder\Block::make('video')
                        ->label('Video')
                        ->icon('heroicon-o-play-circle')
                        ->schema([
                            TextInput::make('naslov')->label('Naslov sekcije'),
                            TextInput::make('src')->label('URL videa')->required(),
                            TextInput::make('poster')->label('URL postera'),
                        ]),

                    Builder\Block::make('map')
                        ->label('Mapa')
                        ->icon('heroicon-o-map')
                        ->schema([
                            TextInput::make('naslov')->label('Naslov')->default('Mapa ponude'),
                            TextInput::make('linkText')->label('Tekst linka')->default('Otvori mapu'),
                            TextInput::make('to')->label('Link')->default('/mapa'),
                            TextInput::make('height')->label('Visina')->default('480px'),
                        ]),

                    Builder\Block::make('spacer')
                        ->label('Razmak')
                        ->icon('heroicon-o-arrows-up-down')
                        ->schema([
                            Select::make('size')
                                ->label('Veličina')
                                ->options(['sm' => 'Mala', 'md' => 'Srednja', 'lg' => 'Velika'])
                                ->default('md'),
                            Toggle::make('divider')->label('Linija razdvajanja'),
                        ]),
                ])
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }
}
