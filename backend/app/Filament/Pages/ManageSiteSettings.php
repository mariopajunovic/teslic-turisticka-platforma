<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
        ]);
    }
}
