<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRole;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Ime')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role')->label('Uloga')->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'aktivan' => 'Aktivan',
                        'na_odobrenju' => 'Na odobrenju',
                        'blokiran' => 'Blokiran',
                        default => $state,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'aktivan' => 'success',
                        'na_odobrenju' => 'warning',
                        'blokiran' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')->label('Registrovan')->dateTime('d.m.Y.')->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')->options(UserRole::class),
                SelectFilter::make('status')->options([
                    'na_odobrenju' => 'Na odobrenju',
                    'aktivan' => 'Aktivan',
                    'blokiran' => 'Blokiran',
                ]),
            ])
            ->recordActions([
                Action::make('odobri')
                    ->label('Odobri nalog')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'na_odobrenju')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'aktivan'])),
                Action::make('blokiraj')
                    ->label('Blokiraj')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== 'blokiran')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'blokiran'])),
                Action::make('odblokiraj')
                    ->label('Odblokiraj')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'blokiran')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'aktivan'])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
