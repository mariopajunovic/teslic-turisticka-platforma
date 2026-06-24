<?php

namespace App\Filament\Resources\Events\Tables;

use App\Enums\ContentStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('naslov')
                    ->label('Naziv')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('datum')
                    ->label('Datum')
                    ->date('d.m.Y.')
                    ->sortable(),
                TextColumn::make('category.label')
                    ->label('Kategorija')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Objavljeno')
                    ->dateTime('d.m.Y.')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ContentStatus::class),
                SelectFilter::make('category_id')
                    ->label('Kategorija')
                    ->relationship('category', 'label'),
            ])
            ->recordActions([
                Action::make('odobri')
                    ->label('Odobri i objavi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== ContentStatus::Objavljeno)
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->update([
                            'status' => ContentStatus::Objavljeno,
                            'published_at' => now(),
                        ]);
                    }),
                Action::make('vrati')
                    ->label('Vrati / odbij')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === ContentStatus::Poslano)
                    ->schema([
                        Textarea::make('razlog')
                            ->label('Razlog (ide vlasniku)')
                            ->required(),
                    ])
                    ->action(function (array $data, $record): void {
                        $record->update([
                            'status' => ContentStatus::Odbijeno,
                            'rejection_reason' => $data['razlog'],
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
