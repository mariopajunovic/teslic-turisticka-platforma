<?php

namespace App\Filament\Actions;

use App\Enums\ContentStatus;
use App\Services\ContentWorkflow;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;

class ReturnAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'vrati';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Vrati na doradu')
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('warning')
            ->visible(fn ($record) => $record->status === ContentStatus::Poslano)
            ->schema([
                Textarea::make('razlog')
                    ->label('Razlog (ide vlasniku na doradu)')
                    ->required(),
            ])
            ->action(fn (array $data, $record) => app(ContentWorkflow::class)->returnForRevision($record, $data['razlog']));
    }
}
