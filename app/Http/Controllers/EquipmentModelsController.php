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

use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentBrand;
use App\Models\Inventory\EquipmentModel;


class EquipmentModelsController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    }

    public function index( Request $request ) {

        $data = EquipmentModel::select(['id', 'name', 'id as action'])
        ->addSelect([
            'category_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_categories')
                    ->whereColumn('inventory_equipment_models.category_id', 'inventory_equipment_categories.id')
                    ->limit(1);
            },
            'brand_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_equipment_brands')
                    ->whereColumn('inventory_equipment_models.brand_id', 'inventory_equipment_brands.id')
                    ->limit(1);
            },
            'equipments_count' => function( $query ){
                $query->selectRaw('count(id)')
                    ->from('inventory_equipments')
                    ->whereColumn('inventory_equipment_models.id', 'inventory_equipments.model_id')
                    ->whereNull('inventory_equipments.deleted_at')
                    ->limit(1);
            },
        ])
        ->get();
        return Inertia::render('EquipmentModels/Index', [
            'data' => $data,
        ]);

    }

    public function create( Request $request ) {

        return Inertia::render('EquipmentModels/Create', [
            'db' => [
                'categories' => EquipmentCategory::all(),
                'brands' => EquipmentBrand::all(),
            ],
        ]);
    }


    public function show( Request $request, int $id ) {
        $data = EquipmentModel::with(['category:id,name', 'brand:id,name'])->find($id);
        return Inertia::render('EquipmentModels/Show', [
            'data' => $data,
            'db' => [],
        ]);
    }
    
    public function store( Request $request ){
        
        $request->validate([
            'name' => ['required'],
            'category' => ['required','array'],
            'brand' => ['required','array'],
        ]);
        
        $row = new EquipmentModel;
        $row->name = $request['name'] ?? NULL;
        $row->category_id = $request['category']['id'] ?? NULL;
        $row->brand_id = $request['brand']['id'] ?? NULL;
        
        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-models.show', $row->id)->with('successMessage', 'Equipment created');
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
        $data = EquipmentModel::with(['category:id,name', 'brand:id,name'])->find($id);
        return Inertia::render('EquipmentModels/Edit', [
            'data' => $data,
            'db' => [
                'categories' => EquipmentCategory::all(),
                'brands' => EquipmentBrand::all(),
            ],
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required"],
        ]);
        
        $row = EquipmentModel::find( $id );
        $row->name = $request['name'] ?? NULL;
        
        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-models.show', $row->id)->with('successMessage', 'Equipment created');
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

    public function destroy( Request $request, int $id ){

        $row = EquipmentModel::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('equipment-models');
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
