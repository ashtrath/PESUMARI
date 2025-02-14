<?php

namespace App\Filament\Resources\InternshipLetterResource\Pages;

use App\Filament\Resources\InternshipLetterResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;

class ListInternshipLetters extends ListRecords
{
    protected static string $resource = InternshipLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('createIndividual')
                    ->label('Surat Magang Individu')
                    ->icon('heroicon-m-user')
                    ->url(InternshipLetterResource::getUrl('create')),
                Action::make('createGroup')
                    ->label('Surat Magang Kelompok')
                    ->icon('heroicon-m-users')
                    ->url(InternshipLetterResource::getUrl('createGroup')),
            ])
                ->label('New Surat Magang')
                ->icon('heroicon-m-chevron-down')
                ->iconPosition('after')
                ->color('primary')
                ->button(),
        ];
    }
}
