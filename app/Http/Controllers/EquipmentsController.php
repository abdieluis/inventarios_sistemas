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

use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentBrand;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentModel;

use App\Models\Inventory\EquipmentOwner;

use App\Models\Inventory\EquipmentFeature;


class EquipmentsController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    private function get_last_years(){
        $current_year = intval(date("Y"));
        $years = [];
        for( $i = $current_year-10 ; $i<=$current_year; $i++ ){
            $years[] = $i;
        }
        return $years;
    }


    public function datatable( Request $request ) {

        $filters = $request['filters'] ?? [];

        $query = Equipment::select([
            'inventory_equipments.*',
            'inventory_equipments.id as action'
        ])->with([
            'category',
            'brand',
            'model',
            'owner',
            'responsives',
            'responsive_equipments' => [
                'responsive'
            ],
        ]);

        $value = $filters['id'] ?? NULL;
        if( $value != NULL ){
            $query->where('inventory_equipments.id', '=', $value);
        }
        $value = $filters['sku'] ?? NULL;
        if( $value != NULL ){
            $query->where('inventory_equipments.sku', '=', $value);
        }

        $value = $filters['status'] ?? NULL;
        if( $value != NULL ){
            $query->where('inventory_equipments.status', '=', $value);
        }

        $value = $filters['category']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'category', function($q) use ($value){
                    $q->where('inventory_equipment_categories.id', '=', $value);
                }
            );
        }
        $value = $filters['brand']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'brand', function($q) use ($value){
                    $q->where('inventory_equipment_brands.id', '=', $value);
                }
            );
        }
        $value = $filters['model']['id'] ?? NULL;
        if( $value != NULL ){
            $query->whereHas(
                'model', function($q) use ($value){
                    $q->where('inventory_equipment_models.id', '=', $value);
                }
            );
        }

        $data = $query->get();

        return [
            'data' => $data,
        ];

    }


    public function index( Request $request ) {

        /*
        $data = Equipment::select([
            'inventory_equipments.*',
            'inventory_equipments.id as action',
            'inventory_responsives.employment_id',
            'go_employees.full_name as employee_name',
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
            'owner_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_owners')
                    ->whereColumn('inventory_equipments.owner_id', 'inventory_equipment_owners.id')
                    ->limit(1);
            },
        ])
        ->leftJoin(
            'inventory_responsives',
            'inventory_responsives.id',
            '=',
            'inventory_responsive_equipments.responsive_id',
        )
        ->leftJoin(
            'inventory_equipments',
            'inventory_equipments.id',
            '=',
            'inventory_responsive_equipments.equipment_id',
        )
        ->leftJoin(
            'go_employees',
            'go_employees.id',
            '=',
            'inventory_responsives.employment_id',
        )
        ->whereNull('inventory_responsives.end_at')
        ->get();
        */

        $data = Equipment::select([
            'inventory_equipments.*',
            'inventory_equipments.id as action'
        ])->with([
            'category',
            'brand',
            'model',
            'owner',

            'responsives',
            'responsive_equipments' => [
                'responsive'
            ],
            /*
            'current_responsive'=> [
                'employment' => [
                    'branch',
                    'area',
                    'title',
                    'employee',
                ],
            ],
            */
        ])
        /*
        ->addSelect([
            'responsive_employee' => function( $query ){
                $query->select('go_employees.full_name')
                    ->from('go_employees')
                    ->whereColumn('go_employees.category_id', 'inventory_equipment_categories.id')
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
            'owner_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_owners')
                    ->whereColumn('inventory_equipments.owner_id', 'inventory_equipment_owners.id')
                    ->limit(1);
            },
        ])
        */
        ->get();

        // dump( $data->toArray() );

        return Inertia::render('Equipments/Index', [
            'data' => $data,
            'db' => [
                'categories' => EquipmentCategory::all(),
                'brands' => EquipmentBrand::all(),
                'models' => EquipmentModel::all(),
                'status' => ['Disponible','Entregado','En Garantía / Mantenimiento','Dañado / Desecho'],
            ],
        ]);
        /*
        return Inertia::render('Employees', [
            'data' => Employee::all()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'edit_url' => URL::route('employees.edit', $employee),
                ];
            }),
            'create_url' => URL::route('employees.create'),
        ]);
        */

    }

    public function create( Request $request ) {

        /*

        if( $request->user()->id != 5 ){
            return Inertia::render('NotAllowed');
        }
        */

       return Inertia::render('Equipments/Create', [
            'db' => [
                'categories' => EquipmentCategory::select(['id','name'])->orderBy('name', 'asc')->get(),
                'brands' => EquipmentBrand::select(['id','name'])->orderBy('name', 'asc')->get(),
                'models' => EquipmentModel::select(['id','name', 'brand_id', 'category_id'])->orderBy('name', 'asc')->get(),
                'owners' => EquipmentOwner::select(['id','name'])->orderBy('name', 'asc')->get(),
                'features' => EquipmentFeature::select(
                    ['id', 'name', 'type', 'categories']
                )->with([
                    'options' => function ($query) {
                        $query->orderBy('name', 'asc');
                    }
                ])->orderBy('name', 'asc')->get(),
                'status' => [ "Disponible", "En Garantía / Mantenimiento", "Dañado / Desecho" ],
                'lifecycle' => [ "Nuevo", "Usado" ],
                'purchase_years' => $this->get_last_years()
            ],
        ]);
    }


    public function show( Request $request, int $id ) {

        $data = Equipment::with([
            'category', 'brand', 'model', 'owner',
            'responsives',
            'responsive_equipments' => [
                'responsive' => [
                    'employment'  => [
                        'branch',
                        'area',
                        'title',
                        'employee',
                    ],
                ]
            ],
        ])->find($id);

        $data->current_responsive = null;
        foreach( $data->responsive_equipments as $responsive_equipment ){
            if( $responsive_equipment->responsive->end_at == null ){
                $data->current_responsive = $responsive_equipment->responsive->toArray() ;
            }
        }

        //dump( $data->toArray() );
        //return;

        return Inertia::render('Equipments/Show', [
            'data' => $data,
            'db' => [
                'features' => EquipmentFeature::select(['id', 'name'])->pluck('name', 'id'),
            ],

        ]);
    }


    public function store( Request $request ){

        $request->validate([
            'category' => ['required','array'],
            'brand' => ['required','array'],
            'model' => ['nullable','array'],
            'owner' => ['required','array'],
            'sku' => ['nullable','numeric','unique:App\Models\Inventory\Equipment,sku', 'max_digits:9'],
            'status' => ['required'],
            'lifecycle' => ['required'],
            'purchase_year' => ['nullable'],
        ]);

        $row = new Equipment;
        $row->category_id = $request['category']['id'] ?? NULL;
        $row->brand_id = $request['brand']['id'] ?? NULL;
        $row->model_id = $request['model']['id'] ?? NULL;
        $row->owner_id = $request['owner']['id'] ?? NULL;
        $row->sku = $request['sku'] ?? NULL;
        $row->serial = $request['serial'] ?? NULL;
        $row->status = $request['status'] ?? NULL;
        $row->lifecycle = $request['lifecycle'] ?? NULL;
        $row->purchase_year = $request['purchase_year'] ?? NULL;
        $row->notes = $request['notes'] ?? NULL;

        $features = [];
        foreach( $request['features'] as $feature_id => $item ){
            if( !is_array( $item) ){
                $features[] = [
                    'id' => null,
                    'name' => $item,
                    'feature_id' => $feature_id,
                ];
            } else {
                $features[] = [
                    'id' => $item['id'] ?? NULL,
                    'name' => $item['name']  ?? NULL,
                    'feature_id' => $item['feature_id']  ?? NULL,
                ];
            }
        }
        $row->features = $features;

        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipments.show', $row->id)->with('successMessage', 'Equipment created');
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

    public function edit( Request $request, int $id ){

        $data = Equipment::with([
            'category', 'brand', 'model', 'owner',
            'responsives',
            'responsive_equipments' => [
                'responsive' => [
                    'employment'  => [
                        'branch',
                        'area',
                        'title',
                        'employee',
                    ],
                ]
            ],
        ])->find($id);

        $data->current_responsive = null;
        foreach( $data->responsive_equipments as $responsive_equipment ){
            if( $responsive_equipment->responsive->end_at != null ){
                $data->current_responsive = $responsive_equipment->responsive;
            }
        }

        $features = [];
        if( is_iterable($data->features) ){
            foreach( $data->features as $item ){
                if( $item['feature_id']!=NULL ){

                    /* is text, number, checkbox */
                    if( 1 ){
                        $features[ $item['feature_id'] ] = $item;
                    }
                    else {
                        $features[ $item['feature_id'] ] = $item['name'];
                    }

                }
            }
        }
        $data->features = $features;

        return Inertia::render('Equipments/Edit', [
            'data' => $data,

            'db' => [
                'categories' => EquipmentCategory::select(['id','name'])->orderBy('name', 'asc')->get(),
                'brands' => EquipmentBrand::select(['id','name'])->orderBy('name', 'asc')->get(),
                'models' => EquipmentModel::select(['id','name', 'brand_id', 'category_id'])->orderBy('name', 'asc')->get(),
                'owners' => EquipmentOwner::select(['id','name'])->orderBy('name', 'asc')->get(),
                'features' => EquipmentFeature::select(
                    ['id', 'name', 'type', 'categories']
                )->with([
                    'options' => function ($query) {
                        $query->orderBy('name', 'asc');
                    }
                ])->orderBy('name', 'asc')->get(),
                'status' => [ "Disponible", "En Garantía / Mantenimiento", "Dañado / Desecho" ],
                'lifecycle' => [ "Nuevo", "Usado" ],
                'purchase_years' => $this->get_last_years()
            ],

        ]);


    }

    public function update( Request $request, int $id ){
        $request->validate([
            'category' => ['required','array'],
            'brand' => ['required','array'],
            'model' => ['nullable','array'],
            'owner' => ['required','array'],
            'sku' => ['nullable','numeric',"unique:App\Models\Inventory\Equipment,sku,$id", 'max_digits:10'],
            'status' => ['required'],
            'lifecycle' => ['required'],
            'purchase_year' => ['nullable'],
        ]);

        $row = Equipment::find($id);
        $row->category_id = $request['category']['id'] ?? NULL;
        $row->brand_id = $request['brand']['id'] ?? NULL;
        $row->model_id = $request['model']['id'] ?? NULL;
        $row->owner_id = $request['owner']['id'] ?? NULL;
        $row->sku = $request['sku'] ?? NULL;
        $row->serial = $request['serial'] ?? NULL;
        $row->status = $request['status'] ?? NULL;
        $row->lifecycle = $request['lifecycle'] ?? NULL;
        $row->purchase_year = $request['purchase_year'] ?? NULL;
        $row->notes = $request['notes'] ?? NULL;

        $features = [];
        foreach( $request['features'] as $feature_id => $item ){

            if( !is_array( $item) ){
                $features[] = [
                    'id' => null,
                    'name' => $item,
                    'feature_id' => $feature_id,
                ];
            } else {
                $features[] = [
                    'id' => $item['id'] ?? NULL,
                    'name' => $item['name']  ?? NULL,
                    'feature_id' => $item['feature_id']  ?? NULL,
                ];
            }
        }
        $row->features = $features;

        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro actualizado correctamente"
                ]
            );
            return redirect()->route('equipments.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }

        /*
        $contact->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => [
                    'nullable',
                    Rule::exists('organizations', 'id')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id)),
                ],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );
        return Redirect::back()->with('success', 'Contact updated.');
        */
    }

    public function destroy( Request $request, int $id ){
        $row = Equipment::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('equipments');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se pudo elimianr el registro"
                ]
            );
        }
    }

    public function restore( Request $request, int $id ){
    }

}
