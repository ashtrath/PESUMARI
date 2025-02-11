@php
    use App\Models\StudyProgram;
    use Carbon\Carbon;

    Carbon::setLocale('id');

    $study_program_label = StudyProgram::find($study_program)?->name;
    $formatted_internship_duration = (new NumberFormatter('id', NumberFormatter::SPELLOUT))->format($internship_duration);
@endphp

    <!doctype html>
<html lang="en">
<head>
    <title>Surat Permohonan Magang</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-['Times_New_Roman'] text-[12pt] align-baseline text-pretty">
    <div class="flex justify-between items-start">
        <table>
            <tr>
                <td>Nomor</td>
                <td class="pl-8 pr-2">:</td>
                <td>{{ $letter_number }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td class="pl-8 pr-2">:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td class="pl-8 pr-2">:</td>
                <td>Surat Permohonan Magang</td>
            </tr>
        </table>
        <p class="text-right">
            {{ $letter_created_location }},
            {{ Carbon::parse($letter_created_date)->translatedFormat('d F Y') }}
        </p>

    </div>

    <div class="mt-4">
        <p>Kepada Yth,</p>
        <p><strong>{{ $company_name }}</strong></p>
        <p>{{ $company_address }}</p>
    </div>

    <p class="mt-4 text-justify">
        Dengan hormat, <br /> Dalam rangka memenuhi salah satu persyaratan akademik di lingkungan Institut Bisnis dan
        Informatika Kesatuan (IBIK) Bogor, kami mewajibkan kepada mahasiswa/i untuk melakukan magang di suatu
        Perusahaan/Instansi. Sehubungan dengan hal tersebut kami mengajukan permohonan magang bagi mahasiswa kami
        berikut ini:
    </p>

    <table class="mt-4">
        <tr>
            <td>Nama</td>
            <td class="pl-8 pr-2">:</td>
            <td>{{ $name }}</td>
        </tr>
        <tr>
            <td>NPM</td>
            <td class="pl-8 pr-2">:</td>
            <td>{{ $nim }}</td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td class="pl-8 pr-2">:</td>
            <td>{{ $study_program_label }}</td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td class="pl-8 pr-2">:</td>
            <td>{{  $phone_number }}</td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td class="pl-8 pr-2">:</td>
            <td>{{ $email_address }}</td>
        </tr>
    </table>

    <p class="mt-4 text-justify">
        Sehubungan dengan hal tersebut kami berharap mahasiswa diatas dapat mengikuti magang di {{ $company_name }}.
        Adapun pelaksanaan magang akan dilaksanakan selama {{ $internship_duration }}
        ({{ ucfirst($formatted_internship_duration) }}) Bulan, di mulai
        pada {{ Carbon::parse($internship_start_month)->translatedFormat('F Y') }}.
    </p>

    <p class="mt-4 text-justify">
        Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuan yang diberikan kami ucapkan terima kasih.
    </p>

    <div class="mt-10 text-right">
        <p>Hormat kami,</p>
        <div class="w-32 h-14 ml-auto my-4">
            @inlinedImage(public_path('/storage/signature.jpg'))
        </div>
        <p class="underline">Hj. Nani Cahyani, Dra., M.Si.</p>
        <p>Kepala Career Development Center</p>
    </div>
</body>
</html>
