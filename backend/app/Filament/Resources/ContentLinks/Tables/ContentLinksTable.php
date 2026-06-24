<?php

namespace App\Filament\Resources\ContentLinks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContentLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source')
                    ->label('Sadržaj')
                    ->getStateUsing(fn ($record) => class_basename($record->source_type).': '.optional($record->source)->naslov),
                TextColumn::make('target')
                    ->label('Povezan sa')
                    ->getStateUsing(fn ($record) => class_basename($record->target_type).': '.optional($record->target)->naslov),
                TextColumn::make('created_at')->label('Kreirano')->dateTime('d.m.Y.')->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
