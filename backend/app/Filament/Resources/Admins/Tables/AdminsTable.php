<?php

namespace App\Filament\Resources\Admins\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Ime')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Uloge')
                    ->badge(),
                IconColumn::make('is_super')
                    ->label('Super admin')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Kreiran')
                    ->dateTime('d.m.Y.')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('reset_2fa')
                    ->label('Resetuj 2FA')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->app_authentication_secret = null;
                        $record->app_authentication_recovery_codes = null;
                        $record->save();
                    }),
                Action::make('reset_lozinke')
                    ->label('Resetuj lozinku')
                    ->form([
                        TextInput::make('password')
                            ->label('Nova lozinka')
                            ->password()
                            ->required(),
                    ])
                    ->action(fn ($record, array $data) => $record->update(['password' => $data['password']])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
