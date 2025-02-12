<?php

namespace App\Filament\Resources\InternshipLetterResource\Tables;

use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;

class StudentInternshipLetterTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        return $table->columns([
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
            TextColumn::make('comments.comment')
                ->label('Alasan/Catatan')
                ->placeholder('-')
                ->searchable()
        ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('student_id', auth()->user()->student->nim);
            })
            ->actions([
                ViewAction::make()->hiddenLabel()->tooltip('Detail'),
            ])
            ->bulkActions([]);
    }
}
