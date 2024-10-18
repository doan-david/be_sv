<?php

namespace App\Exports;

use App\Models\ClassName;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassesExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $classes;

    public function __construct($classes)
    {
        $this->class = $classes;
    }

    public function collection()
    {
        return collect($this->classes);
    }

    public function headings(): array {
        return [
            'ID',
            'Mã lớp',
            'Tên lớp',
            'Cố vấn',
            'Thông tin',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        // Apply styles to the header row
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0000FF'],
            ],
        ]);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(40);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
