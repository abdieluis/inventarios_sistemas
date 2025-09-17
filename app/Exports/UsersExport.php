<?php

namespace App\Exports;

use App\Models\User;

use Maatwebsite\Excel\Concerns\{
    WithHeadingRow,
    FromQuery,
    WithHeadings,
    WithMapping,
    Exportable,
    ShouldAutoSize,
    WithStyles
};

use PhpOffice\PhpSpreadsheet\Shared\{
    Date
};

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class UsersExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles, WithMapping {
    

    use Exportable;

    public function styles(Worksheet $sheet){
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }    

    public function headings(): array {
        return [
            'ID USUARIO',
            'NOMBRE',
            'CORREO',
            'ROL',
        ];
    }

    public function query() {
        return User::query();
    }

    public function map( $row ): array {
        return [
            $row->id ?? NULL,
            $row->name ?? NULL,
            $row->email ?? NULL,
            $row->role ?? NULL,
        ];
    }    
}
