<?php

namespace App\Filament\Resources\StudyProgramResource\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;

class StudyProgramTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->label('Nama')
                ->searchable(),

            TextColumn::make('description')
                ->label('Deskripsi'),
            TextColumn::make('students_count')
                ->label('Jumlah Mahasiswa')
                ->alignCenter()
                ->sortable()
                ->counts('students')
        ])
            ->actions([
                EditAction::make()->hiddenLabel()->tooltip('Edit'),
                DeleteAction::make()->hiddenLabel()->tooltip('Delete')
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
