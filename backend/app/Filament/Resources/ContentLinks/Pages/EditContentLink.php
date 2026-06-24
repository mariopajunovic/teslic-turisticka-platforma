<?php

namespace App\Filament\Resources\ContentLinks\Pages;

use App\Filament\Resources\ContentLinks\ContentLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContentLink extends EditRecord
{
    protected static string $resource = ContentLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
