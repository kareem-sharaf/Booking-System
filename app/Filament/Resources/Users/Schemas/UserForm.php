<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema, array $roleOptions): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->autocomplete('new-password')
                ->required(fn(?User $record): bool => $record === null)
                ->dehydrated(fn(?string $state): bool => filled($state))
                ->maxLength(255),
            Select::make('role')
                ->label('Role')
                ->options($roleOptions)
                ->required(),
        ]);
    }
}

