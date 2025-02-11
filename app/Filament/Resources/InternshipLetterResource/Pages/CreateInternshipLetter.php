<?php

namespace App\Filament\Resources\InternshipLetterResource\Pages;

use App\Filament\Resources\InternshipLetterResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CreateInternshipLetter extends CreateRecord
{
    protected static string $resource = InternshipLetterResource::class;

    protected static bool $canCreateAnother = false;

    public function showPreview(): StreamedResponse
    {
        $this->form->validate();

        $pdfBuilder = Pdf::view('pdf.internship-letter', $this->form->getState())
            ->name('internship-letter-'.now()->timestamp.'.pdf')
            ->format(Format::A4)
            ->portrait()
            ->margins(2.06, 1, 0.38, 1, Unit::Inch);

        return response()->streamDownload(function () use ($pdfBuilder) {
            echo base64_decode($pdfBuilder->download()->base64());
        }, $pdfBuilder->downloadName);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $pdf = Pdf::view('pdf.internship-letter', $data)
            ->format(Format::A4)
            ->portrait()
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
