<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsByJobExport implements FromCollection, WithHeadings
{
    protected $jobId;

    /**
     * Constructor untuk menerima job ID
     */
    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Application::where('job_id', $this->jobId)
            ->with(['user', 'job'])
            ->get()
            ->map(function ($application) {
                return [
                    'Nama Pelamar' => $application->user->name,
                    'Email' => $application->user->email,
                    'Posisi' => $application->job->title,
                    'Perusahaan' => $application->job->company,
                    'Status' => ucfirst($application->status),
                    'Tanggal Melamar' => $application->created_at->format('d/m/Y H:i'),
                ];
            });
    }

    /**
     * Headings untuk file Excel
     */
    public function headings(): array
    {
        return [
            'Nama Pelamar',
            'Email',
            'Posisi',
            'Perusahaan',
            'Status',
            'Tanggal Melamar'
        ];
    }
}
