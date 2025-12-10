<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // John Doe melamar ke Software Engineer (job_id: 1)
        Application::create([
            'user_id' => 2, // John Doe
            'job_id' => 1,  // Software Engineer
            'cv' => 'cvs/dummy_cv_john.pdf',
            'status' => 'pending',
        ]);

        // John Doe melamar ke DevOps Engineer (job_id: 4)
        Application::create([
            'user_id' => 2, // John Doe
            'job_id' => 4,  // DevOps Engineer
            'cv' => 'cvs/dummy_cv_john2.pdf',
            'status' => 'accepted',
        ]);

        // Jane Smith melamar ke UI/UX Designer (job_id: 2)
        Application::create([
            'user_id' => 3, // Jane Smith
            'job_id' => 2,  // UI/UX Designer
            'cv' => 'cvs/dummy_cv_jane.pdf',
            'status' => 'pending',
        ]);

        // Jane Smith melamar ke Product Manager (job_id: 5)
        Application::create([
            'user_id' => 3, // Jane Smith
            'job_id' => 5,  // Product Manager
            'cv' => 'cvs/dummy_cv_jane2.pdf',
            'status' => 'rejected',
        ]);

        // John Doe melamar ke Data Analyst (job_id: 3)
        Application::create([
            'user_id' => 2, // John Doe
            'job_id' => 3,  // Data Analyst
            'cv' => 'cvs/dummy_cv_john3.pdf',
            'status' => 'pending',
        ]);
    }
}
