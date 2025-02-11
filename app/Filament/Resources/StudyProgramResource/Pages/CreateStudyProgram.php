<?php

namespace App\Filament\Resources\StudyProgramResource\Pages;

use App\Filament\Resources\StudyProgramResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudyProgram extends CreateRecord
{
    protected static string $resource = StudyProgramResource::class;

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }
}
