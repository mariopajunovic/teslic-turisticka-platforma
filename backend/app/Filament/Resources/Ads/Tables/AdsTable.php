<?php

namespace App\Filament\Resources\Ads\Tables;

use App\Enums\ContentStatus;
use App\Filament\Actions\ApproveAction;
use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\RejectAction;
use App\Filament\Actions\ReturnAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AdsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('naslov')
                    ->label('Naslov')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('izdavac')
                    ->label('Izdavač')
                    ->searchable(),
                TextColumn::make('category.label')
                    ->label('Vrsta')
                    ->badge()
                    ->sortable(),
                TextColumn::make('rok')
                    ->label('Rok')
                    ->date('d.m.Y.')
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
                    ->label('Vrsta')
                    ->relationship('category', 'label'),
            ])
            ->recordActions([
                ApproveAction::make(),
                ReturnAction::make(),
                RejectAction::make(),
                ArchiveAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
