<?php

namespace App\Filament\Resources\StudyProgramResource\Pages;

use App\Filament\Resources\StudyProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudyPrograms extends ListRecords
{
    protected static string $resource = StudyProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
