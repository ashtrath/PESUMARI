<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ShieldSeeder::class,
        ]);

        // Seed Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.mail',
        ])->assignRole('admin');

        // Seed Program Studi
        $studyPrograms = [
            ['name' => 'Ilmu Komputer', 'description' => 'Jurusan Ilmu Komputer.'],
            ['name' => 'Akuntansi', 'description' => 'Jurusan Akuntansi.'],
            ['name' => 'Filsafat & Ilmu Budaya', 'description' => 'Jurusan Filsafat & Ilmu Budaya'],
        ];

        foreach ($studyPrograms as $program) {
            StudyProgram::create($program);
        }

        // Seed Kaprodi
        $kaprodis = [
            [
                'name' => 'John Doe',
                'email' => 'ilkom@test.mail',
                'study_program_id' => StudyProgram::where('name', 'Ilmu Komputer')->first()->id,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'akuntansi@test.mail',
                'study_program_id' => StudyProgram::where('name', 'Akuntansi')->first()->id,
            ],
            [
                'name' => 'Junaedi Doe',
                'email' => 'filsafat@test.mail',
                'study_program_id' => StudyProgram::where('name', 'Filsafat & Ilmu Budaya')->first()->id,
            ],
        ];

        foreach ($kaprodis as $kaprodi) {
            User::factory()->create($kaprodi)
                ->assignRole('kaprodi');
        }

        // Seed Mahasiswa
        $mahasiswas = [
            [
                'name' => 'Rahadian Fahri F',
                'email' => 'mahasiswa1@test.mail',
                'study_program_id' => StudyProgram::where('name', 'Ilmu Komputer')->first()->id,
            ],
            [
                'name' => 'Mahasiswa 2',
                'email' => 'mahasiswa2@test.mail',
                'study_program_id' => StudyProgram::where('name', 'Akuntansi')->first()->id,
            ],
            [
                'name' => 'Mahasiswa 3',
                'email' => 'mahasiswa3@test.mail',
                'study_program_id' => StudyProgram::where('name', 'Filsafat & Ilmu Budaya')->first()->id,
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            $user = User::factory()->create($mahasiswa)
                ->assignRole('mahasiswa');

            // Seed students linked to users
            Student::create([
                'nim' => fake()->unique()->numerify('#########'), // 9-digit unique NIM
                'gender' => fake()->randomElement(['L', 'P']),
                'user_id' => $user->id,
            ]);
        }
    }
}
