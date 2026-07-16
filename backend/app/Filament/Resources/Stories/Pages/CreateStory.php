<?php

namespace App\Filament\Resources\Stories\Pages;

use App\Filament\Resources\Stories\StoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStory extends CreateRecord
{
    protected static string $resource = StoryResource::class;

    use \App\Filament\Concerns\TranslatableCreateRecord;

    protected function getFormActions(): array
    {
        return [];
    }
}
