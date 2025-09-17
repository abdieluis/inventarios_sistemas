<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Inertia\Inertia;

use App\Models\Inventory\Responsive;
use App\Models\Inventory\ResponsiveEquipment;
use App\Models\Inventory\ResponsiveEmployment;

use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentBrand;
use App\Models\Inventory\EquipmentModel;
use App\Models\Inventory\EquipmentAccessory;
use App\Models\Inventory\EquipmentFeature;

use App\Models\Inventory\PhoneLine;
use App\Models\Inventory\ResponsiveEnding;


use App\Models\Go\Branch;
use App\Models\Go\EmploymentArea;
use App\Models\Go\EmploymentTitle;

use App\Models\Go\Employee;
use App\Models\Go\Employment;


class ResponsivesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function datatable( Request $request ) {

        $filters = $request['filters'] ?? [];

        $query = Responsive::select([
            'inventory_responsives.*',
            'inventory_responsives.id as action'
        ])->with([
            'equipments' => [
                'data' => [
                    'category',
                    'brand',
                    'model',
                ],
                'phoneline' => [
                    'modality',
                ],
            ],
            'employment' => [
                'branch',
                'area',
                'title',
                'employee',
            ],
        ]);

        $value = $filters['id'] ?? NULL;
        if( $value != NULL ){
            $query->where('inventory_responsives.id', '=', $value);
        }
        $value = $filters['status'] ?? NULL;
        if( $value != NULL ){
            if( $value == 'Vigente' ){
                $query->whereNull('inventory_responsives.end_at');
            }
            if( $value == 'Finalizada' ){
                $query->whereNotNull('inventory_responsives.end_at');
            }
        }

        $value = $filters['employment']['branch']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'employment.branch', function($q) use ($value){
                    $q->where('go_branches.id', '=', $value);
                }
            );
        }
        $value = $filters['employment']['area']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'employment.area', function($q) use ($value){
                    $q->where('go_employment_areas.id', '=', $value);
                }
            );
        }

        $value = $filters['equipment']['category']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'equipments.data.category', function($q) use ($value){
                    $q->where('inventory_equipment_categories.id', '=', $value);
                }
            );
        }
        $value = $filters['equipment']['brand']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'equipments.data.brand', function($q) use ($value){
                    $q->where('inventory_equipment_brands.id', '=', $value);
                }
            );
        }
        $value = $filters['equipment']['model']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'equipments.data.model', function($q) use ($value){
                    $q->where('inventory_equipment_models.id', '=', $value);
                }
            );
        }
        $value = $filters['equipment']['sku'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'equipments.data', function($q) use ($value){
                    $q->where('inventory_equipments.sku', '=', $value);
                }
            );
        }

        $data = $query->get();

        return [
            'data' => $data,
            'request' => $request['filters'] ?? [],
        ];

    }

    public function index( Request $request ) {

        // $value = $request['employment']['branch']['id'] ?? '';
        // if( $value != '' ){
        //     echo $value;
        //     return 0;
        // }

        // $data = Responsive::select([
        //     'inventory_responsives.*',
        //     'inventory_responsives.id as action'
        // ])->with([
        //     'equipments' => [
        //         'data' => [
        //             'category' => function( $query ) use ($request){
        //                 $value = $request['equipment']['category']['id'] ?? NULL;
        //                 if( $value != NULL ){
        //                     $query->where('inventory_equipment_categories.id', '=', $value);
        //                 }
        //             },
        //             'brand',
        //             'model',
        //         ],
        //         'phoneline' => [
        //             'modality',
        //         ],
        //     ],
        //     'employment' => [
        //         'branch' => function( $query ) use ($request){
        //             $value = $request['employment']['branch']['id'] ?? NULL;
        //             $query->where('go_branches.id', '=', $value);
        //         },
        //     'area',
        //         'title',
        //         'employee',
        //     ],
        // ])->get();


        // return Inertia::render('Responsives/Index', [
        //     'data' => $data,
        //     'filters' => [
        //         'status' => $request['status'] ?? NULL,
        //         'equipment' => [
        //             'category' => $request['equipment']['category'] ?? NULL,
        //             'brands' => $request['equipment']['brand'] ?? NULL,
        //             'models' => $request['equipment']['model'] ?? NULL,
        //         ],
        //         'employment' => [
        //             'branch' => $request['employment']['branch'] ?? NULL,
        //             'area' => $request['employment']['area'] ?? NULL,
        //         ]
        //     ],
        //     'db'  => [
        //         'status' => ['Vigente', 'Finalizada'],
        //         'equipment' => [
        //             'categories' => EquipmentCategory::select(['id','name'])->orderBy('name', 'asc')->get(),
        //             'brands' => EquipmentBrand::select(['id','name'])->orderBy('name', 'asc')->get(),
        //             'models' => EquipmentModel::select(['id','name', 'brand_id', 'category_id'])->orderBy('name', 'asc')->get(),
        //         ],
        //         'employment' => [
        //             'branches' => Branch::select(['id','name'])->orderBy('name', 'asc')->get(),
        //             'areas' => EmploymentArea::select(['id','name'])->orderBy('name', 'asc')->get(),
        //         ]
        //     ]
        // ]);
        // 1. Lógica de filtrado mejorada
        $responsivesQuery = Responsive::query()
            ->with([
                'employment.employee',
                'employment.branch',
                'employment.area',
                'employment.title',
                'equipments.data.category',
                'equipments.data.brand',
                'equipments.data.model',
                'equipments.phoneline.modality'
            ]);

        // Aplicar filtros dinámicamente
        $filters = $request->all();

        // Filtro por ID
        if (isset($filters['id'])) {
            $responsivesQuery->where('id', $filters['id']);
        }

        // Filtro por estatus
        if (isset($filters['status'])) {
            if ($filters['status'] === 'Vigente') {
                $responsivesQuery->whereNull('end_at');
            } elseif ($filters['status'] === 'Finalizada') {
                $responsivesQuery->whereNotNull('end_at');
            }
        }

        // Filtro por planta (branch)
        if (isset($filters['branch_id'])) {
            $responsivesQuery->whereHas('employment.branch', function($query) use ($filters) {
                $query->where('id', $filters['branch_id']);
            });
        }

        // Filtro por área (area)
        if (isset($filters['area_id'])) {
            $responsivesQuery->whereHas('employment.area', function($query) use ($filters) {
                $query->where('id', $filters['area_id']);
            });
        }

        // Filtro por categoría de equipo (category)
        if (isset($filters['category_id'])) {
            $responsivesQuery->whereHas('equipments.data.category', function($query) use ($filters) {
                $query->where('id', $filters['category_id']);
            });
        }

        // Filtro por marca de equipo (brand)
        if (isset($filters['brand_id'])) {
            $responsivesQuery->whereHas('equipments.data.brand', function($query) use ($filters) {
                $query->where('id', $filters['brand_id']);
            });
        }

        // Filtro por modelo de equipo (model)
        if (isset($filters['model_id'])) {
            $responsivesQuery->whereHas('equipments.data.model', function($query) use ($filters) {
                $query->where('id', $filters['model_id']);
            });
        }

        // Filtro por SKU
        if (isset($filters['sku'])) {
            $responsivesQuery->whereHas('equipments.data', function($query) use ($filters) {
                $query->where('sku', 'like', '%' . $filters['sku'] . '%');
            });
        }

        // Filtro por serial
        if (isset($filters['serial'])) {
            $responsivesQuery->whereHas('equipments.data', function($query) use ($filters) {
                $query->where('serial', 'like', '%' . $filters['serial'] . '%');
            });
        }

        // Obtener los datos filtrados y ordenarlos
        $data = $responsivesQuery->latest()->get();

        // 2. Estructura de datos correcta para los filtros
        $dbData = [
            'status' => [['id' => 'Vigente', 'name' => 'Vigente'], ['id' => 'Finalizada', 'name' => 'Finalizada']],
            'branches' => Branch::select('id', 'name')->orderBy('name', 'asc')->get(),
            'areas' => EmploymentArea::select('id', 'name')->orderBy('name', 'asc')->get(),
            'categories' => EquipmentCategory::select('id', 'name')->orderBy('name', 'asc')->get(),
            'brands' => EquipmentBrand::select('id', 'name')->orderBy('name', 'asc')->get(),
            'models' => EquipmentModel::select('id', 'name')->orderBy('name', 'asc')->get(),
        ];

        return Inertia::render('Responsives/Index', [
            'data' => $data,
            'filters' => $request->only(['id', 'status', 'branch_id', 'area_id', 'category_id', 'brand_id', 'model_id', 'sku', 'serial']),
            'db' => $dbData
        ]);

    }

    public function create( Request $request ) {

        /*
        $employments = Employee::select([
            'go_employees.*',
            'go_employments.branch_id',
            'go_employments.area_id',
            'go_employments.title_id',
        ])
        ->leftJoin(
            'go_employments',
            'go_employments.employee_id',
            '=',
            'go_employees.id',
        )
        ->addSelect([
            'branch_name' => function( $query ){
                $query->select('name')
                    ->from('go_branches')
                    ->whereColumn('go_employments.branch_id', 'go_branches.id')
                    ->limit(1);
            },
            'area_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_areas')
                    ->whereColumn('go_employments.area_id', 'go_employment_areas.id')
                    ->limit(1);
            },
            'title_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_titles')
                    ->whereColumn('go_employments.title_id', 'go_employment_titles.id')
                    ->limit(1);
            },
        ])
        ->whereNull( 'go_employments.end_at' )
        ->whereNotNull( 'go_employments.id' )
        ->get();
        */

        $employments = Employment::select([
            'go_employments.*',
            'go_employees.employee_number as employee_number',
            'go_employees.full_name as employee_name',
        ])
        ->leftJoin(
            'go_employees',
            'go_employees.id',
            '=',
            'go_employments.employee_id',
        )
        ->addSelect([
            'branch_name' => function( $query ){
                $query->select('name')
                    ->from('go_branches')
                    ->whereColumn('go_employments.branch_id', 'go_branches.id')
                    ->limit(1);
            },
            'area_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_areas')
                    ->whereColumn('go_employments.area_id', 'go_employment_areas.id')
                    ->limit(1);
            },
            'title_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_titles')
                    ->whereColumn('go_employments.title_id', 'go_employment_titles.id')
                    ->limit(1);
            },
        ])
        ->whereNull([ 'go_employees.deleted_at' ])
        ->whereNull( 'go_employments.end_at' )
        ->whereNotNull( 'go_employments.id' )
        ->get();


        $equipments = Equipment::select([
            'inventory_equipments.*',
        ])
        ->addSelect([
            'category_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_categories')
                    ->whereColumn('inventory_equipments.category_id', 'inventory_equipment_categories.id')
                    ->limit(1);
            },
            'brand_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_brands')
                    ->whereColumn('inventory_equipments.brand_id', 'inventory_equipment_brands.id')
                    ->limit(1);
            },
            'model_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_models')
                    ->whereColumn('inventory_equipments.model_id', 'inventory_equipment_models.id')
                    ->limit(1);
            },
        ])
        ->where( 'inventory_equipments.status', '=', 'Disponible' )
        ->get();

        $phonelines = PhoneLine::where('status', 'Disponible')->get();
        $accessories = EquipmentAccessory::all();

        return Inertia::render('Responsives/Create', [
            'db' => [
                'types' => [
                    ['id' => "SINGLE", 'name' => "Individual"],
                    ['id' => "MULTI", 'name' => "Grupal"]
                ],
                'employments' => $employments,
                'equipments' => $equipments,
                'phonelines' => $phonelines,
                'accessories' => $accessories,
                'equipment' => $request['equipment'] ?? NULL,
                'employee' => $request['employee'] ?? NULL,
            ],
        ]);

    }

    public function store( Request $request ){

        $request->validate([
            'employment' => ['required'],
            'employments' => ['array'],
            'equipments' => ['required', 'array'],
            'accessories' => ['nullable', 'array'],
            'type' => ['required', 'array'],
            'start_at' => ['required'],
        ]);

        $row = new Responsive;
        DB::transaction( function () use ($row, $request) {

            $row->employment_id = $request['employment']['id'] ?? null;
            $row->notes = $request['notes'] ?? null;
            $row->type = $request['type']['id'] ?? null;
            $row->start_at = $request['start_at'] ?? null;

            $accessories = [];
            foreach( $request['accessories'] as $item ){
                $accessories[] = $item['name'];
            }
            $row->accessories = $accessories;

            $row->created_by = $request->user()->id;
            $row->save();

            if( $row->isClean() ){
                foreach( $request['equipments'] as $item ){

                    $responsive_equipment = new ResponsiveEquipment;
                    $responsive_equipment->responsive_id = $row->id;
                    $responsive_equipment->equipment_id = $item['id'];
                    $responsive_equipment->phoneline_id = $item['phoneline']['id'] ?? NULL;
                    $responsive_equipment->amount = null;
                    $responsive_equipment->created_by = $request->user()->id;
                    $responsive_equipment->save();

                    $equipment = Equipment::find( $item['id'] );
                    if( $item['id'] != 370 ) $equipment->status = 'Entregado';
                    $equipment->save();

                    if( $responsive_equipment->phoneline_id != NULL ){
                        $phoneline = PhoneLine::find( $responsive_equipment->phoneline_id );
                        $phoneline->status = 'Asignada';
                        $phoneline->save();
                    }

                }

                if( $row->type == 'MULTI' ){
                    foreach( $request['employments'] as $item ){
                        $responsive_employment = new ResponsiveEmployment;
                        $responsive_employment->responsive_id = $row->id;
                        $responsive_employment->employment_id = $item['id'];
                        $responsive_employment->created_by = $request->user()->id;
                        $responsive_employment->save();
                    }
                }

            }

        });

        if( $row->isClean() ){

            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('responsives.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }

    }

    public function show( Request $request, int $id ){

        $data = Responsive::with([
            'equipments' => [
                'phoneline',
                'data' => [
                    'category',
                    'brand',
                    'model',
                ],
            ],
            'employment' => [
                'branch',
                'area',
                'title',
                'employee'
            ],
            'employments' => [
                'data' => [
                    'branch',
                    'area',
                    'title',
                    'employee'
                ]
            ],
            'ending'
        ])->find($id);

        $phoneLines = PhoneLine::where('status', 'Disponible')->get();

        return Inertia::render('Responsives/Show', [
            'data' => $data,
            'db' => [
                'endings' => ResponsiveEnding::all(),
            ],
            'phoneLines' => $phoneLines,
        ]);

    }

    public function edit( Request $request ){
        return Inertia::render('Contacts/Edit', [
            'contact' => [
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'end_at' => ['required'],
        ]);

        $row = Responsive::find( $id );
        $row->end_at = $request['end_at'] ?? null;
        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro actualizado correctamente"
                ]
            );
            return redirect()->route('responsives.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
        }

    }

    public function destroy( Request $request, int $id ){

        $row = Responsive::find( $id );
        //$row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('equipment-brands');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se pudo elimianr el registro"
                ]
            );
        }

    }

    public function restore( Contact $contact ){
        $contact->restore();
        return Redirect::back()->with('success', 'Contact restored.');
    }


    public function finalize( Request $request, int $id ){

        $request->validate([
            'end_at' => ['required'],
            'ending' => ['required', 'array'],
        ]);

        $row = Responsive::find( $id );
        DB::transaction( function () use ($row, $request) {

            $row->end_at = $request['end_at'] ?? null;
            $row->ending_id = $request['ending']['id'] ?? null;
            $row->ending_notes = $request['ending_notes'] ?? null;

            $row->end_by = $request->user()->id;
            $row->save();

            $responsive = Responsive::with('equipments')->find( $row->id );
            foreach( $responsive->equipments as $item ){

                if( $item->equipment_id!=NULL ){
                    $equipment = Equipment::find( $item->equipment_id );
                    $equipment->status = 'Disponible';
                    $equipment->save();
                }

                if( $item->phoneline_id!=NULL ){
                    $equipment = PhoneLine::find( $item->phoneline_id );
                    $equipment->status = 'Disponible';
                    $equipment->save();
                }

            }

        });

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro actualizado correctamente"
                ]
            );
            return redirect()->route('responsives.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
        }

    }


    public function choose_employee( Request $request ) {
        $search = $request->search;

        $data = Employee::paginate();

            /*aa()
            ->when($search,
                fn ($query) => $query->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('content', 'LIKE', '%'.$search.'%')
            )
            ->paginate();
            */

        return Inertia::render('Responsives/Components/ChooseEmployee', [
            'stories' => $data,
            'search' => $search,
        ]);

    }


    public function print( Request $request, int $id ) {

        $data = Responsive::with([
            'equipments' => [
                'phoneline',
                'data' => [
                    'category',
                    'brand',
                    'model',
                ],
            ],
            'employment' => [
                'branch',
                'area',
                'title',
                'employee'
            ],
            'employments' => [
                'data' => [
                    'branch',
                    'area',
                    'title',
                    'employee'
                ]
            ]
        ])->find($id);

        //return view('responsives.print-format', [ 'data' => $data ]);
        $pdf = \PDF::loadView( 'responsives.print-format', [
            'data' => $data,
            'db' => [
                'features' => EquipmentFeature::select(['id', 'name'])->pluck('name', 'id'),
            ],
        ]);
        return $pdf->stream();

    }

    public function download( Request $request, int $id ) {

        $filename = "responsiva de equipo - $id.pdf";

        $data = Responsive::with([
            'equipments' => [
                'phoneline',
                'data' => [
                    'category',
                    'brand',
                    'model',
                ],
            ],
            'employment' => [
                'branch',
                'area',
                'title',
                'employee'
            ],
            'employments' => [
                'branch',
                'area',
                'title',
                'employee'
            ]
        ])->find($id);

        $pdf = \PDF::loadView( 'responsives.print-format', [
            'data' => $data
        ]);
        return $pdf->download( $filename );

    }

}
