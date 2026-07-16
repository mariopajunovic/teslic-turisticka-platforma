<?php

namespace App\Filament\Resources\Locations\Pages;

use App\Filament\Resources\Locations\LocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    use \App\Filament\Concerns\TranslatableCreateRecord;

    protected function getFormActions(): array
    {
        return [];
    }
}
