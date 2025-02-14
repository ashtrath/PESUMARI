@php
    use App\Models\StudyProgram;
    use Carbon\Carbon;

    Carbon::setLocale('id');

    $formatted_internship_duration = (new NumberFormatter('id', NumberFormatter::SPELLOUT))->format($internship_duration);
@endphp
    <!doctype html>
<html lang="en">
<head>
    <title>Surat Permohonan Magang</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
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
            @inlinedImage(public_path('/images/signature.jpg'))
        </div>
        <p class="underline">Hj. Nani Cahyani, Dra., M.Si.</p>
        <p>Kepala Career Development Center</p>
    </div>

    @pageBreak

    <table class="text-sm border-collapse border">
        <thead>
        <tr>
            <th class="px-4 py-2 border text-left font-bold whitespace-nowrap uppercase">Nama</th>
            <th class="px-4 py-2 border text-left font-bold whitespace-nowrap uppercase">NIM/NPM</th>
            <th class="px-4 py-2 border text-left font-bold whitespace-nowrap uppercase">Program Studi</th>
            <th class="px-4 py-2 border text-left font-bold whitespace-nowrap uppercase">No. Telepon</th>
            <th class="px-4 py-2 border text-left font-bold whitespace-nowrap uppercase">Email</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="px-4 py-2 border whitespace-nowrap">{{ $name }}</td>
            <td class="px-4 py-2 border whitespace-nowrap">{{ $nim }}</td>
            <td class="px-4 py-2 border whitespace-nowrap">{{ StudyProgram::find($study_program)->name }}</td>
            <td class="px-4 py-2 border whitespace-nowrap">{{ $phone_number }}</td>
            <td class="px-4 py-2 border whitespace-nowrap">{{ $email_address }}</td>
        </tr>
        @foreach($mahasiswa_i as $item)
            <tr>
                <td class="px-4 py-2 border whitespace-nowrap">{{ $item['name'] }}</td>
                <td class="px-4 py-2 border whitespace-nowrap">{{ $item['nim'] }}</td>
                <td class="px-4 py-2 border whitespace-nowrap">
                    {{ StudyProgram::find($item['study_program'])->name }}
                </td>
                <td class="px-4 py-2 border whitespace-nowrap">{{ $item['phone_number'] }}</td>
                <td class="px-4 py-2 border whitespace-nowrap">{{ $item['email_address'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
