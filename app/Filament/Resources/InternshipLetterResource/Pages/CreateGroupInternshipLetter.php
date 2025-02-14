<?php

namespace App\Filament\Resources\InternshipLetterResource\Pages;

use App\Filament\Resources\InternshipLetterResource;
use App\Models\StudyProgram;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CreateGroupInternshipLetter extends CreateRecord
{
    protected static string $resource = InternshipLetterResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Buat Surat Magang Kelompok';

    public function showPreview(): StreamedResponse
    {
        $this->form->validate();

        $pdfBuilder = Pdf::view('pdf.group-internship-letter', $this->form->getState())
            ->name('internship-letter-'.now()->timestamp.'.pdf')
            ->format(Format::A4)
            ->portrait()
            ->footerView('pdf.footer')
            ->margins(2.06, 1, 0.38, 1, Unit::Inch);

        return response()->streamDownload(function () use ($pdfBuilder) {
            echo base64_decode($pdfBuilder->download()->base64());
        }, $pdfBuilder->downloadName);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
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
                ]),
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
            Section::make('Infomasi Mahasiswa/i')->schema([
                Fieldset::make('Informasi Ketua Kelompok')->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->prefixIcon('heroicon-o-user')
                        ->maxLength(255)
                        ->columnSpan('full')
                        ->default(auth()->user()->name)
                        ->required()
                        ->live(onBlur: true),
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
                Fieldset::make('Informasi Anggota Kelompok')->schema([
                    Repeater::make('mahasiswa_i')
                        ->schema([
                            Select::make('user_id')
                                ->label('Akun Pengguna')
                                ->options(User::role('mahasiswa')->where('id', '!=',
                                    auth()->user()->id)->pluck('name', 'id'))
                                ->searchable()
                                ->columnSpan('full')
                                ->dehydrated(false)
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                    $user = User::find($state);
                                    if ($user) {
                                        $set('name', $user->name);
                                        $set('nim_ui', $user->student->nim);
                                        $set('nim', $user->student->nim);
                                        $set('study_program_ui', $user->studyProgram->name);
                                        $set('study_program', $user->study_program_id);
                                        $set('email_address', $user->email);
                                    }
                                }),
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->prefixIcon('heroicon-o-user')
                                ->maxLength(255)
                                ->columnSpan('full')
                                ->required()
                                ->live(onBlur: true),
                            TextInput::make('nim_ui')
                                ->label('NIM/NPM')
                                ->prefixIcon('heroicon-o-identification')
                                ->length(9)
                                ->disabled()
                                ->dehydrated(false)
                                ->markAsRequired(),
                            Hidden::make('nim')
                                ->required(),
                            Select::make('study_program_ui')
                                ->label('Program Studi')
                                ->prefixIcon('heroicon-o-academic-cap')
                                ->options(StudyProgram::pluck('name', 'id')->toArray())
                                ->preload()
                                ->searchable()
                                ->disabled()
                                ->dehydrated(false)
                                ->markAsRequired(),
                            Hidden::make('study_program')
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
                                ->required(),
                        ])
                        ->addActionLabel('Tambah Anggota Kelompok')
                        ->reorderableWithButtons()
                        ->reorderableWithDragAndDrop(false)
                        ->columns(2)
                        ->columnSpanFull()
                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                        ->collapsible()
                        ->hiddenLabel()
                        ->minItems(1)
                        ->maxItems(10)
                ]),
            ])->columnSpan(2)->collapsible(),
        ])->columns(3);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $pdf = Pdf::view('pdf.group-internship-letter', $data)
            ->format(Format::A4)
            ->portrait()
            ->footerView('pdf.footer')
            ->margins(2.06, 1, 0.38, 1, Unit::Inch);

        $fileName = 'internship-letter-'.now()->timestamp.'.pdf';
        $path = "internship-letters/{$fileName}";
        $pdf->disk('public')->save($path);

        return $this->getModel()::create([
            'student_id' => auth()->user()->student->nim,
            'letter_path' => $path,
            'status' => 'pending',
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Kirim')
                ->icon('heroicon-o-paper-airplane')
                ->requiresConfirmation(),
            Action::make('showPreview')
                ->label('Pratinjau Surat')
                ->icon('heroicon-o-eye')
                ->action('showPreview')
                ->keyBindings(['mod+shift+s'])
                ->color('gray'),
            $this->getCancelFormAction()
                ->label('Batal')
                ->icon('heroicon-o-arrow-uturn-left'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }
}
