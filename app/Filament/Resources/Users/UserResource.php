<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure(
            schema: $schema,
            roleOptions: self::roleOptions(),
        );
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure(
            table: $table,
            roleOptions: self::roleOptions(),
        );
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderByDesc('created_at');
    }

    public static function canViewAny(): bool
    {
        return self::currentUser()?->can('viewAny', User::class) ?? false;
    }

    public static function canCreate(): bool
    {
        return self::currentUser()?->can('create', User::class) ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return self::currentUser()?->can('update', $record) ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return self::currentUser()?->can('delete', $record) ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return self::currentUser()?->can('delete', User::class) ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    private static function currentUser(): ?User
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user;
    }

    /**
     * @return array<string, string>
     */
    private static function roleOptions(): array
    {
        return collect(User::ROLES)
            ->mapWithKeys(fn(string $role) => [$role => ucfirst($role)])
            ->all();
    }
}

