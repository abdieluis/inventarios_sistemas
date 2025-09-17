<?php

namespace App\Exports;

use App\Models\Go\Employment;
use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentFeature;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentFeatureOption;

use App\Models\Inventory\Responsive;
use App\Models\Inventory\ResponsiveEquipment;

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


class EquipmentsExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles, WithMapping {
    

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

        $features = EquipmentFeature::pluck('name');

        $row = [
            'ID EQUIPO',
            'STATUS',
            'ESTADO',
            'TIPO DE EQUIPO',
            'MARCA',
            'MODELO',
            'PLACA',
            'SERIE',
        ];

        foreach( $features as $item ){
            $row[] = $item;
        }

        $row[] = 'PROPIETARIO';
        $row[] = 'NOTAS';

        return $row;
    }

    public function query() {
        return Equipment::with([
            'category',
            'brand',
            'model',
            'owner',
        ]);
    }

    public function map( $row ): array {

        $features = EquipmentFeature::pluck('name', 'id');

        $output= [
            $row->id ?? NULL,
            $row->status ?? NULL,
            $row->lifecycle ?? NULL,
            $row->category->name ?? NULL,
            $row->brand->name ?? NULL,
            $row->model->name ?? NULL,
            $row->sku ?? NULL,
            $row->serial ?? NULL,
        ];

        $featureValues = [];
        foreach( $features as $id=>$name ){
            $featureValues[ $id ] = "";
        }

        foreach( $row->features as $item ){
            $featureValues[ $item['feature_id'] ] = $item['name'];
        }

        foreach( $features as $id=>$name ){
            $output[] = $featureValues[ $id ];
        }

        $output[]= $row->owner->name;
        $output[] = $row->notes;

        return $output;
    }
}
