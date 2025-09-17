<?php

namespace App\Exports;

use App\Models\Go\Employment;
use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentFeature;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentFeatureOption;

use App\Models\Inventory\PhoneLine;

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


class PhonelinesExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles, WithMapping {
    

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
            'ID EQUIPO',
            'ESTATUS',
            'NÚMERO',
            'ICCID',
            'COMPAÑIA',
            'PLAN',
            'MODALIDAD',
            'NOTAS',
        ];
    }

    public function query() {
        return Phoneline::with([
            'modality',
        ]);
    }

    public function map( $row ): array {
        return [
            $row->id ?? NULL,
            $row->status ?? NULL,
            $row->number ?? NULL,
            $row->iccid ?? NULL,
            $row->company ?? NULL,
            $row->modality->name ?? NULL,
            $row->scope ?? NULL,
            $row->notes ?? NULL,
        ];
    }    
}
