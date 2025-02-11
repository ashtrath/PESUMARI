<?php

namespace App\Filament\Resources\UserResource\Forms;

use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use TomatoPHP\FilamentHelpers\Contracts\FormBuilder;

class UserForm extends FormBuilder
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Fieldset::make('Informasi Akun')->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->prefixIcon('heroicon-o-user')
                        ->maxLength(255)
                        ->required(),
                    TextInput::make('email')
                        ->prefixIcon('heroicon-o-envelope')
                        ->maxLength(255)
                        ->email()
                        ->unique(User::class, ignoreRecord: true)
                        ->required(),
                    TextInput::make('password')
                        ->label('Kata Sandi')
                        ->prefixIcon('heroicon-o-key')
                        ->password()
                        ->revealable()
                        ->rule(Password::default())
                        ->autocomplete('new-password')
                        ->dehydrated(fn($state): bool => filled($state))
                        ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                        ->live(debounce: 500)
                        ->same('passwordConfirmation')
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn($livewire) => $livewire instanceof CreateRecord),
                    TextInput::make('passwordConfirmation')
                        ->label("Konfirmasi Kata Sandi")
                        ->prefixIcon('heroicon-o-key')
                        ->password()
                        ->revealable()
                        ->required()
                        ->visible(fn(Get $get): bool => filled($get('password')))
                        ->dehydrated(false),
                    Select::make('role')
                        ->label('Role')
                        ->prefixIcon('heroicon-o-user-group')
                        ->options(Role::where('name', '!=', 'admin')->pluck('name', 'name')->toArray())
                        ->preload()
                        ->live()
                        ->searchable()
                        ->required(),
                    Select::make('study_program_id')
                        ->label('Program Studi')
                        ->prefixIcon('heroicon-o-academic-cap')
                        ->relationship('studyProgram', 'name')
                        ->preload()
                        ->searchable()
                        ->visible(fn(Get $get) => $get('role') === 'mahasiswa' || $get('role') === 'kaprodi')
                        ->required(),
                ]),
                Fieldset::make('Informasi Mahasiswa')
                    ->relationship('student')
                    ->schema([
                        TextInput::make('nim')
                            ->label('NPM/NIM')
                            ->prefixIcon('heroicon-o-identification')
                            ->unique(Student::class, ignoreRecord: true)
                            ->numeric()
                            ->length(9)
                            ->required(),
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->prefixIcon('heroicon-o-users')
                            ->options([
                                'L' => 'Laki-Laki',
                                'P' => 'Perempuan',
                            ])
                            ->native(false)
                            ->required(),
                    ])->visible(fn(Get $get): bool => $get('role') === 'mahasiswa')
            ])->columnSpan(2),
            Section::make()->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?User $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ])->columnSpan(1)
        ])->columns(3);
    }
}
