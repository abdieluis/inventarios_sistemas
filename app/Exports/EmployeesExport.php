<?php

namespace App\Exports;

use App\Models\Go\Employment;
use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentFeature;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentFeatureOption;

use App\Models\Go\Employee;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
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


class EmployeesExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles, WithMapping {
    
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
            'ID EMPLEADO',
            'NUMERO EMPLEADO',
            'NOMBRE EMPLEADO',
            'PLANTA',
            'ÁREA',
            'PUESTO',
        ];
    }

    public function query() {
        return Employee::with([
            'current_employment' => [
                'branch',
                'area',
                'title',
            ],
        ]);
    }

    public function map( $row ): array {
        return [
            $row->id ?? NULL,
            $row->employee_number ?? NULL,
            $row->full_name ?? NULL,
            $row->current_employment->branch->name ?? NULL,
            $row->current_employment->area->name ?? NULL,
            $row->current_employment->title->name ?? NULL,
        ];
    }    
}
