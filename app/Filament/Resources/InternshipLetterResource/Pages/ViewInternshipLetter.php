<?php

namespace App\Filament\Resources\InternshipLetterResource\Pages;

use App\Enum\LetterStatus;
use App\Filament\Resources\InternshipLetterResource;
use App\Models\InternshipLetter;
use Filament\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewInternshipLetter extends ViewRecord
{
    protected static string $resource = InternshipLetterResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Lampiran Surat Magang')->schema([
                ViewEntry::make('letter_path')
                    ->view('pdf.preview', ['url' => $this->record->letter_path]),
            ])->columnSpan(2)->extraAttributes(['class' => 'h-full [&>header]:h-14 [&>:not(header)]:h-[calc(100%-56px)] [&>:not(header)_*]:h-full']),
            Grid::make(1)->schema([
                Section::make('Informasi Surat')->schema([
                    TextEntry::make('status')
                        ->badge(),
                    TextEntry::make('submission_date')
                        ->label('Tanggal Penyerahan')
                        ->date('d F Y'),
                    TextEntry::make('approval_date')
                        ->label('Tanggal Persetujuan')
                        ->placeholder('-')
                        ->date('d F Y'),
                    TextEntry::make('processing_date')
                        ->label('Tanggal Penyetakan')
                        ->placeholder('-')
                        ->date('d F Y'),
                ])->collapsible()->inlineLabel(),
                Section::make('Informasi Mahasiswa/i')->schema([
                    TextEntry::make('student.user.name')
                        ->label('Nama Lengkap'),
                    TextEntry::make('student.nim')
                        ->label('NPM/NIM'),
                    TextEntry::make('student.user.studyProgram.name')
                        ->label('Program Studi'),
                    TextEntry::make('student.user.email')
                        ->label('Email'),
                ])
            ])->columnSpan(1)
        ])->columns(3);
    }

    protected function getActions(): array
    {
        return [
            Action::make('accept')
                ->label('Terima')
                ->color('success')
                ->icon('heroicon-m-check')
                ->action(fn(InternshipLetter $record) => $record->updateStatus(LetterStatus::APPROVED, auth()->id()))
                ->visible(auth()->user()->hasPermissionTo('accept_internship::letter')),
            Action::make('reject')
                ->label('Tolak')
                ->color('danger')
                ->icon('heroicon-m-x-mark')
                ->action(fn(InternshipLetter $record) => $record->updateStatus(LetterStatus::REJECTED, auth()->id()))
                ->visible(auth()->user()->hasPermissionTo('accept_internship::letter')),
        ];
    }
}
