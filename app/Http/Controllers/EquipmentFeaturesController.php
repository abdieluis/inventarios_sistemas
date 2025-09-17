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

use App\Models\Inventory\EquipmentFeature;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentFeatureOption;

class EquipmentFeaturesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {

        $data = EquipmentFeature::select(['id', 'name', 'type', 'id as action'])->get();

        return Inertia::render('EquipmentFeatures/Index', [
            'data' => $data,
        ]);

    }

    public function create( Request $request ) {

        return Inertia::render('EquipmentFeatures/Create', [
            'db' => [
                'types' => ["Campo de Texto", "Valor Númerico", "Checkbox", "Lista desplegable", "Conjunto de datos"],
                'categories' => EquipmentCategory::select(['id','name'])->get(),
            ],
        ]);

    }


    public function show( Request $request, int $id ) {

        $data = EquipmentFeature::find( $id );
        $data->options = EquipmentFeatureOption::select(['id', 'name', 'feature_id', 'id as action'])->where('feature_id', '=', $id )->get();

        return Inertia::render('EquipmentFeatures/Show', [
            'data' => $data,
            'db' => [],
        ]);

    }
    
    
    public function store( Request $request ){
        
        $request->validate([
            'name' => ['required','unique:App\Models\Inventory\EquipmentFeature,name'],
            'type' => ['required'],
            'categories' => ['nullable','array'],
        ]);

        $row = new EquipmentFeature;
        $row->name = $request['name'] ?? NULL;
        $row->type = $request['type'] ?? NULL;
        $row->categories = $request['categories'] ?? [];
        
        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-features.show', $row->id)->with('successMessage', 'Equipment created');
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
        $data = EquipmentFeature::find($id);
        return Inertia::render('EquipmentFeatures/Edit', [
            'data' => $data,
            'db' => [
                'types' => ["Campo de Texto", "Valor Númerico", "Checkbox", "Lista desplegable", "Conjunto de datos"],
                 'categories' => EquipmentCategory::select(['id','name'])->get(),
            ],
        ]);
    }

    public function update( Request $request, int $id ){
        $request->validate([
            'name' => ["required", "unique:App\Models\Inventory\EquipmentFeature,name,$id"],
            'type' => ['required'],
            'categories' => ['nullable','array'],
        ]);
        
        $row = EquipmentFeature::find( $id );
        $row->name = $request['name'] ?? NULL;
        $row->type = $request['type'] ?? NULL;
        $row->categories = $request['categories'] ?? [];
        
        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-features.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = EquipmentFeature::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('equipment-features', $row->id);
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se pudo elimianr el registro"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }
    }

    public function restore( Request $request, int $id ){
    }

}
