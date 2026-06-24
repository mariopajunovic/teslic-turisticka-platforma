<?php

namespace App\Filament\Resources\Activities\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->label('Vrijeme')->dateTime('d.m.Y. H:i')->sortable(),
                TextColumn::make('log_name')->label('Kanal')->badge(),
                TextColumn::make('description')->label('Akcija'),
                TextColumn::make('causer.name')->label('Korisnik')->placeholder('—'),
                TextColumn::make('subject_type')
                    ->label('Entitet')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '—'),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label('Kanal')
                    ->options(['default' => 'Sadržaj', 'auth' => 'Prijave']),
            ]);
    }
}
