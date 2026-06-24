<?php

namespace App\Filament\Resources\ContentLinks\Pages;

use App\Filament\Resources\ContentLinks\ContentLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentLinks extends ListRecords
{
    protected static string $resource = ContentLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
