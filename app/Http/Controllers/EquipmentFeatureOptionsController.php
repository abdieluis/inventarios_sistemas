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
use App\Models\Inventory\EquipmentFeatureOption;

class EquipmentFeatureOptionsController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request, int $feature_id ) {

        $data = EquipmentFeature::select([
            'id', 'name', 'id as name'
        ])
        ->with(['options'])
        ->find( $feature_id );

        return Inertia::render('EquipmentFeatures/Options/Index', [
            'data' => $data,
        ]);

    }

    public function create( Request $request, int $feature_id ) {
        $data = EquipmentFeature::find( $feature_id );
        return Inertia::render('EquipmentFeatures/Options/Create', [            
            'data' => $data,
            'db' => [
            ],
        ]);
    }

    public function show( Request $request, int $feature_id, int $id ) {
        $data = EquipmentFeature::find( $feature_id );
        $data->option = EquipmentFeatureOption::where('feature_id', '=', $feature_id)->find( $id );

        return Inertia::render('EquipmentFeatures/Options/Show', [
            'data' => $data,
            'db' => [
            ],
        ]);
    }
    
    
    public function store( Request $request, int $feature_id ){
        
        $request->validate([
            'name' => ['required','max:255','unique:App\Models\Inventory\EquipmentFeatureOption,name' ],
        ]);
        
        $row = new EquipmentFeatureOption;
        $row->feature_id = $feature_id;
        $row->name = $request['name'];

        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-features.options.show', [$row->feature_id, $row->id])->with('successMessage', 'Equipment created');
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

    public function edit( Request $request, int $feature_id, int $id ){

        $data = EquipmentFeature::find( $feature_id );
        $data->option = EquipmentFeatureOption::where('feature_id', '=', $feature_id)->find( $id );

        return Inertia::render('EquipmentFeatures/Options/Edit', [
            'data' => $data,
            'db' => [
            ],
        ]);
    }

    public function update( Request $request, int $feature_id, int $id ){

        $request->validate([
            'name' => ['required','max:255','unique:App\Models\Inventory\EquipmentFeatureOption,name' ],
        ]);
        
        $row = EquipmentFeatureOption::where('feature_id', '=', $feature_id)->find( $id );
        $row->name = $request['name'];

        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro actualizado correctamente"
                ]
            );
            return redirect()->route('equipment-features.options.show', [$row->feature_id, $row->id])->with('successMessage', 'Equipment created');
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

    public function destroy( Request $request, int $feature_id, int $id ){
        $row = EquipmentFeatureOption::where('feature_id', '=', $feature_id)->find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('equipment-features.show', $feature_id);
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

    public function restore( Request $request, int $feature_id, int $id ){
    }

}
