<?php

namespace App\Filament\Pages;

use App\Settings\StraniceSettings;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class ManagePageTexts extends SettingsPage
{
    protected static string $settings = StraniceSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Postavke';

    protected static ?string $title = 'Tekstovi stranica';

    public static function canAccess(): bool
    {
        return auth()->user()?->can('sistemske postavke') ?? false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Kontakt')
                ->schema([
                    TextInput::make('kontakt_naslov')->label('Naslov')->required(),
                    Textarea::make('kontakt_uvod')->label('Uvod')->rows(3),
                ])
                ->columns(1),
            Section::make('Pridruži se')
                ->schema([
                    TextInput::make('pridruzi_naslov')->label('Naslov')->required(),
                    Textarea::make('pridruzi_uvod')->label('Uvod')->rows(3),
                ])
                ->columns(1),
            Section::make('Registracija biznis')
                ->schema([
                    TextInput::make('reg_biznis_naslov')->label('Naslov')->required(),
                    Textarea::make('reg_biznis_uvod')->label('Uvod')->rows(3),
                ])
                ->columns(1),
            Section::make('Registracija autor')
                ->schema([
                    TextInput::make('reg_autor_naslov')->label('Naslov')->required(),
                    Textarea::make('reg_autor_uvod')->label('Uvod')->rows(3),
                ])
                ->columns(1),
            Section::make('Prijava / Registracija / Lozinka')
                ->schema([
                    TextInput::make('prijava_naslov')->label('Naslov prijave')->required(),
                    TextInput::make('registracija_naslov')->label('Naslov registracije')->required(),
                    Textarea::make('registracija_uvod')->label('Uvod registracije')->rows(3),
                    TextInput::make('zaboravljena_naslov')->label('Naslov zaboravljene lozinke')->required(),
                    Textarea::make('zaboravljena_uvod')->label('Uvod zaboravljene lozinke')->rows(3),
                ])
                ->columns(1),
        ]);
    }
}
