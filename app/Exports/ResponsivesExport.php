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
    WithColumnFormatting,
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


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\{
    NumberFormat,
    Fill,
    Style,
    Color
};


class ResponsivesExport implements WithColumnFormatting, FromQuery, WithHeadings, ShouldAutoSize, WithStyles, WithMapping {
    

    use Exportable;


    public function columnFormats(): array {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'M' => NumberFormat::FORMAT_TEXT,            
            'W' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet){
        $colors = [
            'responsive' => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'fce5cd'],
                ],
            ],
            'employment' => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'fff2cc'],
                ],
            ],
            'equipment' => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'd9ead3'],
                ],
            ],
            'phoneline' => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'cfe2f3'],
                ],
            ],
            'responsive_start' => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'd9d2e9'],
                ],
            ],
            'responsive_end' => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'ead1dc'],
                ],
            ],
        ];

        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],

            'A:D'  => $colors['responsive'],
            'C:G'  => $colors['employment'],
            'H:Q'  => $colors['equipment'],
            'R:V'  => $colors['phoneline'],
            'W'  => $colors['responsive'],
            'X:Z'  => $colors['responsive_end'],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }


    public function headings(): array {
        return [
            'ID RESPONSIVA',
            'FECHA INICIO',

            'NUMERO EMPLEADO',
            'NOMBRE EMPLEADO',
            'PLANTA',
            'ÁREA',
            'PUESTO',

            'ID EQUIPO',
            'ESTATUS DE EQUIPO',
            'ESTADO DEL ',
            'TIPO DE EQUIPO',
            'MARCA',
            'MODELO',
            'PLACA',
            'SERIE',
            'AÑO DE COMPRA',
            'PROPIETARIO',

            'LINEA TELEFONICA',
            'ICCID',
            'COMPAÑIA',
            'PLAN',
            'MODALIDAD',

            'PAGARÉ',

            'FECHA FINALIZACIÓN',
            'MOTIVO DE FINALIZACIÓN',
            'NOTAS DE FINALIZACIÓN',
        ];
    }

    /*
    public function collection() {

        $features = EquipmentFeature::pluck( 'name', 'id' );
        $featureNames = EquipmentFeature::pluck( 'name');

        $featuresArray = [];
        foreach( $features as $item ){
            $featuresArray[] = [];
        }        

        $data = Equipment::select([
            'inventory_equipments.*'
        ])->with([
            'category',
            'brand',
            'model',
            'owner',
        ])
        ->get();

        $cols= collect([
            [
                'ID',
                'FECHA INICIO',
                'EMPLEADO',
                'PLANTA',
                'ÁREA',
                'PUESTO',
            ]
        ]);

        $data = ResponsiveEquipment::select([
            'inventory_responsives.id as ID',
            'inventory_responsives.start_at as responsive_start_at',

            'go_employees.full_name as employee_name',
            'go_branches.name as branch_name',
            'go_employment_areas.name as employment_area_name',
            'go_employment_titles.name as employment_title_name',

            'inventory_responsive_equipments.*',
            'inventory_equipments.*',
            
            'inventory_equipment_categories.name as equipment_category_name',
            'inventory_equipment_brands.name as equipment_brand_name',
            'inventory_equipment_models.name as equipment_model_name',

            'inventory_responsives.end_at as responsive_end_at',

        ])
        ->rightJoin(
            'inventory_responsives',
            'inventory_responsives.id',
            '=',
            'inventory_responsive_equipments.responsive_id',
        )
        ->leftJoin(
            'go_employments',
            'go_employments.id',
            '=',
            'inventory_responsives.employment_id',
        )
        ->leftJoin(
            'go_employees',
            'go_employees.id',
            '=',
            'go_employments.employee_id',
        )

        ->leftJoin(
            'go_branches',
            'go_branches.id',
            '=',
            'go_employments.branch_id',
        )
        ->leftJoin(
            'go_employment_areas',
            'go_employment_areas.id',
            '=',
            'go_employments.area_id',
        )
        ->leftJoin(
            'go_employment_titles',
            'go_employment_titles.id',
            '=',
            'go_employments.title_id',
        )


        ->leftJoin(
            'inventory_equipments',
            'inventory_equipments.id',
            '=',
            'inventory_responsive_equipments.equipment_id',
        )
        ->leftJoin(
            'inventory_equipment_categories',
            'inventory_equipment_categories.id',
            '=',
            'inventory_equipments.category_id',
        )
        ->leftJoin(
            'inventory_equipment_brands',
            'inventory_equipment_brands.id',
            '=',
            'inventory_equipments.brand_id',
        )->leftJoin(
            'inventory_equipment_models',
            'inventory_equipment_models.id',
            '=',
            'inventory_equipments.model_id',
        )
        ->get();
        /*
        $output = collect();
        $output->push(
            array_merge([
                'ID',
                'ESTATUS',
                'ESTADO',
                'CATEGORÍA',
                'MARCA',
                'MODELO',
                'PLACA',
                'NO. SERIE',
                'PROPIETARIO',
                'AÑO DE COMPRA'
            ], $featureNames->toArray() )
        );

        foreach( $data as $row ){

            $output->push([
                $row->id,
                $row->status,
                $row->lifecycle,
                $row->category->name ?? NULL,
                $row->brand->name ?? NULL,
                $row->model->name ?? NULL,
                $row->sku,
                $row->serial,
                $row->owner->name ?? NULL,
                $row->purchase_year,
                json_encode($row->features),
            ]);
        }

        return $data;

    }
    */


    public function query() {
        return ResponsiveEquipment::with(
            [
                'responsive' => [
                    'employment' => [
                        'employee',
                        'branch',
                        'area',
                        'title',
                    ]
                ],
                'data' => [
                    'category',
                    'brand',
                    'model',
                    'owner'
                ],
                'phoneline' => [
                    'modality',
                ],
            ]
        );
    }
    
    public function map( $row ): array {
        return [
            $row->responsive->id ?? NULL,
            //$row->responsive->start_at,
            //Date::dateTimeToExcel( $row->responsive->start_at ),

            date_format( date_create($row->responsive->start_at), "d/m/Y" ),

            $row->responsive->employment->employee->employee_number ?? NULL,
            $row->responsive->employment->employee->full_name ?? NULL,
            $row->responsive->employment->branch->name ?? NULL,
            $row->responsive->employment->area->name ?? NULL,
            $row->responsive->employment->title->name ?? NULL,

            $row->data->id ?? NULL,
            $row->data->status ?? NULL,
            $row->data->lifecycle ?? NULL,
            $row->data->category->name ?? NULL,
            $row->data->brand->name ?? NULL,
            $row->data->model->name ?? NULL,
            $row->data->sku ?? NULL,
            $row->data->serial ?? NULL,
            $row->data->purchase_year ?? NULL,
            $row->data->owner->name ?? NULL,

            $row->phoneline->number ?? NULL,
            $row->phoneline->iccid ?? NULL,
            $row->phoneline->company ?? NULL,
            $row->phoneline->modality->name ?? NULL,
            $row->phoneline->scope ?? NULL,

            $row->amount ?? NULL,

            $row->responsive->end_at ?? NULL,
            $row->responsive->ending->name ?? NULL,
            $row->responsive->ending_notes ?? NULL,
        ];
    }    
}

