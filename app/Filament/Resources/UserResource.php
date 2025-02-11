<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Forms\UserForm;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Tables\UserTable;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static int $globalSearchResultsLimit = 20;
    protected static ?string $slug = 'user-management/users';

    protected static ?int $navigationSort = -1;
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return UserForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return UserTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
        ];
    }
}
