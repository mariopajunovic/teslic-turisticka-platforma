<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Naziv')
                ->required(),
            Hidden::make('guard_name')
                ->default('admin'),
            CheckboxList::make('permissions')
                ->label('Ovlaštenja')
                ->relationship('permissions', 'name'),
        ]);
    }
}
