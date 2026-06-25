<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class PageBlocks
{
    public static function all(): array
    {
        return [
            static::block('hero', 'Hero', 'heroicon-o-photo', [
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

            static::block('section_header', 'Naslov sekcije', 'heroicon-o-bars-3-bottom-left', [
                TextInput::make('title')->label('Naslov')->required(),
                TextInput::make('linkText')->label('Tekst linka'),
                TextInput::make('to')->label('Link'),
            ]),

            static::block('rich_text', 'Tekst', 'heroicon-o-document-text', [
                RichEditor::make('sadrzaj')->label('Sadržaj'),
            ]),

            static::block('card_grid', 'Mreža kartica', 'heroicon-o-squares-2x2', [
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

            static::block('cta', 'Poziv na akciju (CTA)', 'heroicon-o-megaphone', [
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

            static::block('category_nav', 'Navigacija kategorija', 'heroicon-o-squares-plus', [
                Repeater::make('items')
                    ->label('Stavke')
                    ->schema([
                        TextInput::make('label')->label('Naziv')->required(),
                        TextInput::make('icon')->label('Ikona')->default('tag'),
                        TextInput::make('to')->label('Link')->required(),
                    ])
                    ->columns(3),
            ]),

            static::block('gallery', 'Galerija', 'heroicon-o-photo', [
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

            static::block('video', 'Video', 'heroicon-o-play-circle', [
                TextInput::make('naslov')->label('Naslov sekcije'),
                TextInput::make('src')->label('URL videa')->required(),
                TextInput::make('poster')->label('URL postera'),
            ]),

            static::block('map', 'Mapa', 'heroicon-o-map', [
                TextInput::make('naslov')->label('Naslov')->default('Mapa ponude'),
                TextInput::make('linkText')->label('Tekst linka')->default('Otvori mapu'),
                TextInput::make('to')->label('Link')->default('/mapa'),
                TextInput::make('height')->label('Visina')->default('480px'),
            ]),

            static::block('stepper', 'Koraci (Stepper)', 'heroicon-o-list-bullet', [
                TextInput::make('naslov')->label('Naslov sekcije'),
                Repeater::make('steps')
                    ->label('Koraci')
                    ->schema([
                        TextInput::make('title')->label('Naslov koraka')->required(),
                        Textarea::make('text')->label('Opis')->rows(2),
                    ]),
            ]),

            static::block('info_panel', 'Info panel', 'heroicon-o-information-circle', [
                TextInput::make('naslov')->label('Naslov'),
                Repeater::make('items')
                    ->label('Stavke')
                    ->schema([
                        TextInput::make('icon')->label('Ikona')->default('info'),
                        TextInput::make('label')->label('Oznaka')->required(),
                        TextInput::make('value')->label('Vrijednost')->required(),
                        TextInput::make('href')->label('Link (opciono)'),
                    ])
                    ->columns(2),
            ]),

            static::block('faq', 'Pitanja i odgovori (FAQ)', 'heroicon-o-question-mark-circle', [
                TextInput::make('naslov')->label('Naslov sekcije'),
                Repeater::make('items')
                    ->label('Pitanja')
                    ->schema([
                        TextInput::make('q')->label('Pitanje')->required(),
                        Textarea::make('a')->label('Odgovor')->rows(2)->required(),
                    ]),
            ]),

            static::block('stats', 'Statistika / brojači', 'heroicon-o-chart-bar', [
                TextInput::make('naslov')->label('Naslov sekcije'),
                Repeater::make('items')
                    ->label('Brojači')
                    ->schema([
                        TextInput::make('value')->label('Vrijednost')->required(),
                        TextInput::make('label')->label('Oznaka')->required(),
                    ])
                    ->columns(2),
            ]),

            static::block('partners', 'Partneri (traka logotipa)', 'heroicon-o-building-office-2', [
                TextInput::make('naslov')->label('Naslov sekcije'),
                Repeater::make('items')
                    ->label('Partneri')
                    ->schema([
                        TextInput::make('name')->label('Naziv')->required(),
                        TextInput::make('logo')->label('Logo (URL)'),
                        TextInput::make('url')->label('Link (opciono)'),
                    ])
                    ->columns(3),
            ]),

            static::block('featured_story', 'Izdvojena priča', 'heroicon-o-star', [
                TextInput::make('naslov')->label('Naslov sekcije'),
                TextInput::make('slug')->label('Slug priče')
                    ->helperText('Ostaviti prazno za posljednju izdvojenu priču.'),
            ]),

            static::block('author', 'Autor', 'heroicon-o-user-circle', [
                TextInput::make('ime')->label('Ime')->required(),
                TextInput::make('uloga')->label('Uloga'),
                Textarea::make('bio')->label('Biografija')->rows(3),
                TextInput::make('avatar')->label('Avatar (URL)'),
            ]),

            static::block('spacer', 'Razmak', 'heroicon-o-arrows-up-down', [
                Select::make('size')
                    ->label('Veličina')
                    ->options(['sm' => 'Mala', 'md' => 'Srednja', 'lg' => 'Velika'])
                    ->default('md'),
                Toggle::make('divider')->label('Linija razdvajanja'),
            ]),
        ];
    }

    protected static function block(string $name, string $label, string $icon, array $schema): Builder\Block
    {
        return Builder\Block::make($name)
            ->label($label)
            ->icon($icon)
            ->schema([...$schema, static::settings()]);
    }

    protected static function settings(): Section
    {
        return Section::make('Izgled bloka')
            ->statePath('settings')
            ->schema([
                Select::make('background')
                    ->label('Pozadina')
                    ->options([
                        'transparent' => 'Bez (prozirno)',
                        'surface' => 'Bijela',
                        'surface-alt' => 'Svijetla siva',
                        'primary-tint' => 'Teal svijetla',
                        'primary' => 'Teal puna',
                    ])
                    ->default('transparent'),
                Select::make('padding')
                    ->label('Vertikalni razmak')
                    ->options([
                        'none' => 'Bez',
                        'sm' => 'Mali',
                        'md' => 'Srednji',
                        'lg' => 'Veliki',
                    ])
                    ->default('none'),
                Select::make('width')
                    ->label('Širina sadržaja')
                    ->options([
                        'contain' => 'Standardna',
                        'narrow' => 'Uska',
                        'full' => 'Puna',
                    ])
                    ->default('contain'),
                Toggle::make('hidden')->label('Sakrij blok')->default(false),
            ])
            ->columns(2)
            ->collapsed();
    }
}
