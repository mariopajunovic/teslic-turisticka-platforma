<?php

namespace App\Filament\Actions;

use App\Enums\ContentStatus;
use App\Services\ContentWorkflow;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;

class RejectAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'odbij';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Odbij')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->visible(fn ($record) => $record->status === ContentStatus::Poslano)
            ->schema([
                Textarea::make('razlog')
                    ->label('Razlog odbijanja (ide vlasniku)')
                    ->required(),
            ])
            ->action(fn (array $data, $record) => app(ContentWorkflow::class)->reject($record, $data['razlog']));
    }
}
