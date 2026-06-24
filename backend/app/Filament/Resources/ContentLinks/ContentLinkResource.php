<?php

namespace App\Filament\Resources\ContentLinks;

use App\Filament\Resources\ContentLinks\Pages\CreateContentLink;
use App\Filament\Resources\ContentLinks\Pages\EditContentLink;
use App\Filament\Resources\ContentLinks\Pages\ListContentLinks;
use App\Filament\Resources\ContentLinks\Schemas\ContentLinkForm;
use App\Filament\Resources\ContentLinks\Tables\ContentLinksTable;
use App\Models\ContentLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContentLinkResource extends Resource
{
    protected static ?string $model = ContentLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static string|UnitEnum|null $navigationGroup = 'Taksonomija';

    protected static ?string $modelLabel = 'veza';

    protected static ?string $pluralModelLabel = 'Povezani sadržaj';

    public static function canAccess(): bool
    {
        return auth()->user()?->can('upravljanje sadržajem') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ContentLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentLinksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentLinks::route('/'),
            'create' => CreateContentLink::route('/create'),
            'edit' => EditContentLink::route('/{record}/edit'),
        ];
    }
}
