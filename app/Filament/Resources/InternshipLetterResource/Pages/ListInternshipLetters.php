<?php

namespace App\Filament\Resources\InternshipLetterResource\Pages;

use App\Filament\Resources\InternshipLetterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternshipLetters extends ListRecords
{
    protected static string $resource = InternshipLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
