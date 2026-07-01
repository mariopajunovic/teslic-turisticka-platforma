<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class ManageSiteSettings extends SettingsPage
{
    protected static string $settings = SiteSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Postavke';

    protected static ?string $title = 'Postavke sajta';

    public static function canAccess(): bool
    {
        return auth()->user()?->can('sistemske postavke') ?? false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Brend')
                ->schema([
                    TextInput::make('brand_naziv')->label('Naziv sajta')->required(),
                    TextInput::make('brand_logo_tekst')->label('Logo (tekst)')->required(),
                ])
                ->columns(2),
            Section::make('Kontakt')
                ->schema([
                    TextInput::make('kontakt_adresa')->label('Adresa')->required(),
                    TextInput::make('kontakt_telefon')->label('Telefon')->required(),
                    TextInput::make('kontakt_email')->label('E-mail')->email()->required(),
                ])
                ->columns(3),
            Section::make('Footer')
                ->schema([
                    Textarea::make('footer_opis')->label('Opis')->rows(3),
                    TextInput::make('copyright')->label('Copyright'),
                    Repeater::make('social')
                        ->label('Društvene mreže')
                        ->schema([
                            TextInput::make('name')->label('Ikona')->required(),
                            TextInput::make('label')->label('Naziv'),
                            TextInput::make('href')->label('Link')->url(),
                        ])
                        ->columns(3),
                    TagsInput::make('partneri')
                        ->label('Partneri'),
                ]),
            Section::make('SEO i pristup')
                ->description('Kontrola indeksiranja i režima održavanja — korisno za dev server.')
                ->schema([
                    Toggle::make('google_indeksiranje')
                        ->label('Dozvoli Google indeksiranje')
                        ->helperText('Isključi na dev serveru da pretraživači ne indeksiraju sajt (noindex + robots.txt).'),
                    Toggle::make('odrzavanje')
                        ->label('Režim održavanja')
                        ->helperText('Kad je uključeno, posjetioci vide stranicu održavanja s poljem za lozinku.'),
                    TextInput::make('odrzavanje_lozinka')
                        ->label('Lozinka za pristup')
                        ->helperText('Posjetilac unosi ovu lozinku da otključa frontend.'),
                    TextInput::make('odrzavanje_minuta')
                        ->label('Trajanje otključavanja (min)')
                        ->numeric()
                        ->minValue(1)
                        ->default(120),
                    Textarea::make('odrzavanje_poruka')
                        ->label('Poruka na stranici održavanja')
                        ->rows(2)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
