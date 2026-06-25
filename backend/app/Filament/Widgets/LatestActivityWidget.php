<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Spatie\Activitylog\Models\Activity;

class LatestActivityWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Posljednje aktivnosti')
            ->query(
                Activity::query()->with('causer')->latest()
            )
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('description')
                    ->label('Opis')
                    ->wrap(),
                TextColumn::make('subject_type')
                    ->label('Tip')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '—')
                    ->badge(),
                TextColumn::make('causer.name')
                    ->label('Administrator')
                    ->placeholder('Sistem'),
                TextColumn::make('created_at')
                    ->label('Vrijeme')
                    ->since()
                    ->sortable(),
            ]);
    }
}
