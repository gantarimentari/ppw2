<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobVacancy;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobVacancy::create([
            'title' => 'Software Engineer',
            'description' => 'Kami mencari Software Engineer yang berpengalaman dalam pengembangan aplikasi web menggunakan Laravel dan React.',
            'company' => 'PT Tech Indonesia',
            'location' => 'Jakarta',
            'salary' => 12000000,
        ]);

        JobVacancy::create([
            'title' => 'UI/UX Designer',
            'description' => 'Dibutuhkan UI/UX Designer kreatif untuk merancang antarmuka aplikasi mobile dan web yang user-friendly.',
            'company' => 'PT Digital Creative',
            'location' => 'Bandung',
            'salary' => 8000000,
        ]);

        JobVacancy::create([
            'title' => 'Data Analyst',
            'description' => 'Mencari Data Analyst untuk menganalisis data bisnis dan membuat visualisasi data yang informatif.',
            'company' => 'PT Data Solutions',
            'location' => 'Surabaya',
            'salary' => 10000000,
        ]);

        JobVacancy::create([
            'title' => 'DevOps Engineer',
            'description' => 'Dibutuhkan DevOps Engineer untuk mengelola infrastruktur cloud dan CI/CD pipeline.',
            'company' => 'PT Cloud Systems',
            'location' => 'Jakarta',
            'salary' => 15000000,
        ]);

        JobVacancy::create([
            'title' => 'Product Manager',
            'description' => 'Kami mencari Product Manager yang dapat memimpin tim dalam mengembangkan produk digital.',
            'company' => 'PT Startup Innovate',
            'location' => 'Jakarta',
            'salary' => 18000000,
        ]);
    }
}
