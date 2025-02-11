<?php

namespace App\Filament\Resources\StudyProgramResource\Forms;

use App\Models\StudyProgram;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use TomatoPHP\FilamentHelpers\Contracts\FormBuilder;

class StudyProgramForm extends FormBuilder
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('name')
                    ->label('Nama Studi Program')
                    ->prefixIcon('heroicon-o-academic-cap')
                    ->maxLength(255)
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
            ])->columnSpan(2),
            Section::make()->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?StudyProgram $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?StudyProgram $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ])->columnSpan(1)
        ])->columns(3);
    }
}
