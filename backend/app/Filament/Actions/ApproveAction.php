<?php

namespace App\Filament\Actions;

use App\Enums\ContentStatus;
use App\Services\ContentWorkflow;
use Filament\Actions\Action;

class ApproveAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'odobri';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Odobri i objavi')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->visible(fn ($record) => $record->status !== ContentStatus::Objavljeno)
            ->requiresConfirmation()
            ->action(fn ($record) => app(ContentWorkflow::class)->approve($record));
    }
}
