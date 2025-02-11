<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyProgramResource\Forms\StudyProgramForm;
use App\Filament\Resources\StudyProgramResource\Pages;
use App\Filament\Resources\StudyProgramResource\RelationManagers\UsersRelationManager;
use App\Filament\Resources\StudyProgramResource\Tables\StudyProgramTable;
use App\Models\StudyProgram;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class StudyProgramResource extends Resource
{
    protected static ?string $model = StudyProgram::class;
    protected static ?string $modelLabel = 'Program Studi';
    protected static ?string $pluralModelLabel = 'Program Studi';

    protected static int $globalSearchResultsLimit = 10;
    protected static ?string $slug = 'letter-management/study-programs';

    protected static ?int $navigationSort = -1;
    protected static ?string $navigationGroup = 'Manajemen Surat Magang';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return StudyProgramForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return StudyProgramTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudyPrograms::route('/'),
            'create' => Pages\CreateStudyProgram::route('/create'),
            'edit' => Pages\EditStudyProgram::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Deskripsi' => $record->description,
        ];
    }
}
