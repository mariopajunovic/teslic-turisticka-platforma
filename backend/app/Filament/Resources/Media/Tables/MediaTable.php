<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('original_url'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('model_type')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '—'),
                TextColumn::make('collection_name')
                    ->badge(),
                TextColumn::make('size')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' KB' : '—'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
