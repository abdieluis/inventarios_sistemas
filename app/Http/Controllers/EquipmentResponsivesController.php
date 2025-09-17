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

use App\Models\Inventory\EquipmentResponsive;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentBrand;
use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentAccessory;


use App\Models\Go\Employee;
use App\Models\Go\Employment;


class EquipmentResponsivesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {

        $data = EquipmentResponsive::select([
            'inventory_equipment_responsives.*',
            'go_employees.employee_number as employee_number',
            'go_employees.full_name as employee_name',
        ])
        ->leftJoin(
            'inventory_equipments',
            'inventory_equipments.id',
            '=',
            'inventory_equipment_responsives.equipment_id',
        )
        ->leftJoin(
            'go_employments',
            'go_employments.id',
            '=',
            'inventory_equipment_responsives.employment_id',
        )
        ->leftJoin(
            'go_employees',
            'go_employees.id',
            '=',
            'go_employments.employee_id',
        )
        
        ->addSelect([
            'employment_branch_name' => function( $query ){
                $query->select('name')
                    ->from('go_branches')
                    ->whereColumn('go_employments.branch_id', 'go_branches.id')
                    ->limit(1);
            },
            'employment_area_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_areas')
                    ->whereColumn('go_employments.area_id', 'go_employment_areas.id')
                    ->limit(1);
            },
            'employment_title_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_titles')
                    ->whereColumn('go_employments.title_id', 'go_employment_titles.id')
                    ->limit(1);
            },

            'equipment_category_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_categories')
                    ->whereColumn('inventory_equipments.category_id', 'inventory_equipment_categories.id')
                    ->limit(1);
            },
            'equipment_brand_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_brands')
                    ->whereColumn('inventory_equipments.brand_id', 'inventory_equipment_brands.id')
                    ->limit(1);
            },
            'equipment_model_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_models')
                    ->whereColumn('inventory_equipments.model_id', 'inventory_equipment_models.id')
                    ->limit(1);
            },

        ])
        ->whereNull([ 'inventory_equipments.deleted_at', 'go_employments.deleted_at', 'go_employees.deleted_at' ])
        ->whereNull( 'go_employments.end_at' )
        ->whereNotNull( 'go_employments.id' )
        ->get();

        return Inertia::render('EquipmentResponsives/Index', [
            'data' => $data,
        ]);
        
    }

    public function create() {

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

        $accessories = EquipmentAccessory::all();
        
        return Inertia::render('EquipmentResponsives/Create', [
            'db' => [
                'employments' => $employments,
                'equipments' => $equipments,
                'accessories' => $accessories,
                'equipment' => $request['equipment'] ?? NULL,
                'employee' => $request['employee'] ?? NULL,
            ],
        ]);

    }
    
    public function store( Request $request ){
        
        $request->validate([
            'employment' => ['required'],
            'equipment' => ['required'],
            'start_at' => ['required'],
            'amount' => ['required', 'numeric'],
            'accessories' => ['nullable','array'],
        ]);

        $row = new EquipmentResponsive;

        $row->employment_id = $request['employment'];
        $row->equipment_id = $request['equipment'];
        $row->amount = $request['amount'];
        $row->notes = $request['notes'] ?? null;
        $row->start_at = $request['start_at'] ?? null;

        $accessories = [];
        foreach( $request['accessories'] as $item ){
            $accessories[] = $item['name'];
        }
        $row->accessories = $accessories;

        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){

            $equipment = Equipment::find( $row->equipment_id );
            $equipment->status = 'Entregado';
            $equipment->save();

            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-responsives.show', $row->id)->with('successMessage', 'Equipment created');
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

        $data = EquipmentResponsive::with([
            'equipment' => [
                'category',
                'brand',
            ],
            'employment' => [
                'branch',
                'area',
                'title',
                'employee'
            ]
        ])->find($id);

        return Inertia::render('EquipmentResponsives/Show', [
            'data' => $data
        ]);
        
    }

    public function edit( Request $request ){
        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'organization_id' => $contact->organization_id,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'city' => $contact->city,
                'region' => $contact->region,
                'country' => $contact->country,
                'postal_code' => $contact->postal_code,
                'deleted_at' => $contact->deleted_at,
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update( Request $request ){
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
    }

    public function destroy( Contact $contact ){
        $contact->delete();
        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore( Contact $contact ){
        $contact->restore();
        return Redirect::back()->with('success', 'Contact restored.');
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

        return Inertia::render('EquipmentResponsives/Components/ChooseEmployee', [
            'stories' => $data,
            'search' => $search,
        ]);

    }

    public function print( Request $request, int $id ) {

        $data = EquipmentResponsive::with([
            'equipment' => ['category','brand',],
            'employment' => ['branch','area','title','employee']
        ])->find($id);

        $pdf = \PDF::loadView( 'equipment-responsives.print-format', [
            'data' => $data 
        ]);
        return $pdf->stream();
    }

    public function download( Request $request, int $id ) {

        $filename = "responsiva de equipo - $id.pdf";

        $data = EquipmentResponsive::with([
            'equipment' => ['category','brand',],
            'employment' => ['branch','area','title','employee']
        ])->find($id);

        $pdf = \PDF::loadView( 'equipment-responsives.print-format', [
            'data' => $data 
        ] );
        return $pdf->download( $filename );

    }


    public function print_promissory_note( Request $request, int $id ) {

        $data = EquipmentResponsive::with([
            'equipment' => ['category','brand',],
            'employment' => ['branch','area','title','employee']
        ])->find($id);

        $pdf = \PDF::loadView( 'equipment-responsives.print-format-promissory-note', [
            'data' => $data 
        ]);
        return $pdf->stream();
    }

    public function download_promissory_note( Request $request, int $id ) {

        $filename = "responsiva de equipo - $id.pdf";

        $data = EquipmentResponsive::with([
            'equipment' => ['category','brand',],
            'employment' => ['branch','area','title','employee']
        ])->find($id);

        $pdf = \PDF::loadView( 'equipment-responsives.print-format-promissory-note', [
            'data' => $data 
        ] );
        return $pdf->download( $filename );

    }

}
