<?php

namespace App\Filament\Resources\StudyProgramResource\Pages;

use App\Filament\Resources\StudyProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudyProgram extends EditRecord
{
    protected static string $resource = StudyProgramResource::class;

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
