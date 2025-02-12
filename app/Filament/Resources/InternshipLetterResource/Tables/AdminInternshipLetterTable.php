<?php

namespace App\Filament\Resources\InternshipLetterResource\Tables;

use App\Models\InternshipLetter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;

class AdminInternshipLetterTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('student.user.name')
                ->label('Nama Mahasiswa/i')
                ->description(fn(InternshipLetter $record) => $record->student->nim)
                ->searchable(),
            TextColumn::make('student.user.studyProgram.name')
                ->label('Program Studi')
                ->searchable(),
            TextColumn::make('submission_date')
                ->label('Tanggal Penyerahan')
                ->date('d F Y')
                ->sortable(),
            TextColumn::make('status')
                ->badge(),
            TextColumn::make('approval_date')
                ->label('Tanggal Persetujuan')
                ->placeholder('-')
                ->date('d F Y')
                ->sortable(),
            TextColumn::make('processing_date')
                ->label('Tanggal Penyetakan')
                ->placeholder('-')
                ->date('d F Y')
                ->sortable(),
        ])
            ->actions([
                ViewAction::make()->hiddenLabel()->tooltip('Detail'),
                DeleteAction::make()->hiddenLabel()->tooltip('Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
