<?php

namespace App\Filament\Resources\InternshipLetterResource\Tables;

use App\Models\InternshipLetter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;

class KaprodiInternshipLetterTable extends TableBuilder
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
            TextColumn::make('comments.comment')
                ->label('Alasan/Catatan')
                ->placeholder('-')
                ->searchable()
        ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->whereHas('student.user', function (Builder $query) {
                    $query->where('study_program_id', auth()->user()->study_program_id);
                });
            })
            ->actions([
                ViewAction::make()->hiddenLabel()->tooltip('Detail'),
            ])
            ->bulkActions([]);
    }
}
