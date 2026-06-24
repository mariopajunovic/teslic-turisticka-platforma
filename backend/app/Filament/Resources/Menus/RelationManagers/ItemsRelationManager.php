<?php

namespace App\Filament\Resources\Menus\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Stavke';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')
                ->label('Naziv')
                ->required()
                ->maxLength(255),
            TextInput::make('url')
                ->label('Link')
                ->required()
                ->default('#'),
            Select::make('parent_id')
                ->label('Nadređena stavka')
                ->placeholder('— vrhovni nivo —')
                ->options(fn () => $this->getOwnerRecord()
                    ->items()
                    ->whereNull('parent_id')
                    ->pluck('label', 'id'))
                ->searchable(),
            TextInput::make('sort')
                ->label('Redoslijed')
                ->numeric()
                ->default(0),
            Toggle::make('visible')
                ->label('Vidljivo')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('label')
                    ->label('Naziv')
                    ->searchable(),
                TextColumn::make('url')
                    ->label('Link'),
                TextColumn::make('parent.label')
                    ->label('Nadređena')
                    ->placeholder('—'),
                TextColumn::make('sort')
                    ->label('Red.'),
                IconColumn::make('visible')
                    ->label('Vidljivo')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
