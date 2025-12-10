<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * Return template data (contoh baris)
     */
    public function array(): array
    {
        return [
            [
                'Software Engineer',
                'PT Tech Indonesia',
                'Jakarta',
                'Kami mencari Software Engineer yang berpengalaman dalam pengembangan aplikasi web menggunakan Laravel...',
                12000000
            ],
            [
                'UI/UX Designer',
                'PT Digital Creative',
                'Bandung',
                'Dibutuhkan UI/UX Designer kreatif untuk merancang antarmuka aplikasi mobile dan web yang user-friendly...',
                8000000
            ]
        ];
    }

    /**
     * Headings untuk file Excel
     */
    public function headings(): array
    {
        return [
            'Title',
            'Company',
            'Location',
            'Description',
            'Salary'
        ];
    }

    /**
     * Styling untuk worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]
            ],
        ];
    }
}
