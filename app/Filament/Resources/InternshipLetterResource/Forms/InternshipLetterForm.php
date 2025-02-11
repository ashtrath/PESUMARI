<?php

namespace App\Filament\Resources\InternshipLetterResource\Forms;

use App\Models\StudyProgram;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use TomatoPHP\FilamentHelpers\Contracts\FormBuilder;

class InternshipLetterForm extends FormBuilder
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Fieldset::make('Informasi Mahasiswa/i')->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->prefixIcon('heroicon-o-user')
                        ->maxLength(255)
                        ->columnSpan('full')
                        ->default(auth()->user()->name)
                        ->required(),
                    TextInput::make('nim_ui')
                        ->label('NIM/NPM')
                        ->prefixIcon('heroicon-o-identification')
                        ->length(9)
                        ->default(auth()->user()->student?->nim)
                        ->disabled()
                        ->dehydrated(false)
                        ->markAsRequired(),
                    Hidden::make('nim')
                        ->default(auth()->user()->student?->nim)
                        ->required(),
                    Select::make('study_program_ui')
                        ->label('Program Studi')
                        ->prefixIcon('heroicon-o-academic-cap')
                        ->options(StudyProgram::pluck('name', 'id')->toArray())
                        ->preload()
                        ->searchable()
                        ->default(auth()->user()->study_program_id)
                        ->disabled()
                        ->dehydrated(false)
                        ->markAsRequired(),
                    Hidden::make('study_program')
                        ->default(auth()->user()->study_program_id)
                        ->required(),
                    TextInput::make('phone_number')
                        ->label('Nomor Telepon')
                        ->prefixIcon('heroicon-o-phone')
                        ->tel()
                        ->telRegex('/^(?=.{7,})(\+62 ((\d{3}([ -]\d{3,})([- ]\d{4,})?)|(\d+)))|(\(\d+\) \d+)|\d{3}( \d+)+|(\d+[ -]\d+)|\d+/')
                        ->required(),
                    TextInput::make('email_address')
                        ->label('Email')
                        ->prefixIcon('heroicon-o-envelope')
                        ->email()
                        ->default(auth()->user()->email)
                        ->required(),
                ]),
                Fieldset::make('Detail Magang')->schema([
                    TextInput::make('company_name')
                        ->label('Nama Perusahaan')
                        ->prefixIcon('heroicon-o-building-office-2')
                        ->maxLength(255)
                        ->columnSpan('full')
                        ->required(),
                    TextInput::make('company_address')
                        ->label('Alamat Perusahaan')
                        ->prefixIcon('heroicon-o-map-pin')
                        ->maxLength(255)
                        ->columnSpan('full')
                        ->required(),
                    DatePicker::make('internship_start_month')
                        ->label('Bulan Mulai Magang')
                        ->prefixIcon('heroicon-o-calendar-days')
                        ->native(false)
                        ->default(now())
                        ->minDate(now()->startOfDay())
                        ->locale('id')
                        ->displayFormat('F, Y')
                        ->required(),
                    TextInput::make('internship_duration')
                        ->label('Durasi Magang (Bulan)')
                        ->prefixIcon('heroicon-o-clock')
                        ->suffix('Bulan')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(12)
                        ->default(3)
                        ->required(),
                ])
            ])->columnSpan(2),
            Section::make('Metadata Surat')->schema([
                TextInput::make('letter_number')
                    ->label('Nomor Surat')
                    ->prefixIcon('heroicon-o-hashtag')
                    ->placeholder('123/XXXX/IBIK/2025')
                    ->required(),
                TextInput::make('letter_created_location')
                    ->label('Lokasi Pembuatan Surat')
                    ->prefixIcon('heroicon-o-map-pin')
                    ->default('Bogor')
                    ->required(),
                DatePicker::make('letter_created_date')
                    ->label('Tanggal Pembuatan Surat')
                    ->prefixIcon('heroicon-o-calendar-days')
                    ->native(false)
                    ->default(now())
                    ->maxDate(now())
                    ->locale('id')
                    ->displayFormat('j F Y')
                    ->required(),
            ])->columnSpan(1),
        ])->columns(3);
    }
}
