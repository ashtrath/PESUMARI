<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternshipLetterResource\Forms\InternshipLetterForm;
use App\Filament\Resources\InternshipLetterResource\Pages;
use App\Filament\Resources\InternshipLetterResource\Tables\InternshipLetterTable;
use App\Models\InternshipLetter;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class InternshipLetterResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = InternshipLetter::class;
    protected static ?string $modelLabel = 'Surat Magang';
    protected static ?string $pluralModelLabel = 'Surat Magang';

    protected static ?string $slug = 'letter-management/internship-letters';

    protected static ?int $navigationSort = -1;
    protected static ?string $navigationGroup = 'Manajemen Surat Magang';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return InternshipLetterForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return InternshipLetterTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInternshipLetters::route('/'),
            'create' => Pages\CreateInternshipLetter::route('/create'),
            'view' => Pages\ViewInternshipLetter::route('/{record}'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'accept',
            'reject',
        ];
    }
}
