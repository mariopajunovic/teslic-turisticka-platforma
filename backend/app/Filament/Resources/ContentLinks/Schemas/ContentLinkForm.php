<?php

namespace App\Filament\Resources\ContentLinks\Schemas;

use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Schemas\Schema;

class ContentLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            MorphToSelect::make('source')
                ->label('Sadržaj')
                ->types(self::types())
                ->searchable()
                ->required(),
            MorphToSelect::make('target')
                ->label('Povezan sa')
                ->types(self::types())
                ->searchable()
                ->required(),
        ]);
    }

    protected static function types(): array
    {
        return [
            Type::make(Business::class)->titleAttribute('naslov')->label('Biznis'),
            Type::make(Location::class)->titleAttribute('naslov')->label('Lokalitet'),
            Type::make(Event::class)->titleAttribute('naslov')->label('Događaj'),
            Type::make(Ad::class)->titleAttribute('naslov')->label('Oglas'),
            Type::make(Story::class)->titleAttribute('naslov')->label('Priča'),
        ];
    }
}
