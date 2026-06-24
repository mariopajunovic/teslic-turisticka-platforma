<?php

namespace App\Filament\Actions;

use App\Enums\ContentStatus;
use App\Services\ContentWorkflow;
use Filament\Actions\Action;

class ArchiveAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'arhiviraj';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Arhiviraj')
            ->icon('heroicon-o-archive-box')
            ->color('gray')
            ->visible(fn ($record) => $record->status === ContentStatus::Objavljeno)
            ->requiresConfirmation()
            ->action(fn ($record) => app(ContentWorkflow::class)->archive($record));
    }
}
