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

use App\Models\Inventory\EquipmentAccessory;


class EquipmentAccessoriesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {

        $data = EquipmentAccessory::select(['id', 'name', 'id as action'])->get();
        return Inertia::render('EquipmentAccessories/Index', [
            'data' => $data,
        ]);

    }

    public function create( Request $request ) {
        return Inertia::render('EquipmentAccessories/Create', [
            'db' => [
            ],
        ]);
    }


    public function show( Request $request, int $id ) {
        $data = EquipmentAccessory::find($id);
        return Inertia::render('EquipmentAccessories/Show', [
            'data' => $data,
            'db' => [],
        ]);
    }
    
    
    public function store( Request $request ){
        
        $request->validate([
            'name' => ['required','unique:App\Models\Inventory\EquipmentAccessory,name'],
        ]);
        
        $row = new EquipmentAccessory;
        $row->name = $request['name'] ?? NULL;
        
        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('equipment-accessories.show', $row->id)->with('successMessage', 'Equipment created');
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
        $data = EquipmentAccessory::find($id);
        return Inertia::render('EquipmentAccessories/Edit', [
            'data' => $data,
            'db' => [],
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Inventory\EquipmentAccessory,name,$id"],
        ]);
        
        $row = EquipmentAccessory::find( $id );
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
            return redirect()->route('equipment-accessories.show', $row->id)->with('successMessage', 'Equipment created');
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

        $row = EquipmentAccessory::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('equipment-accessories', $row->id);
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
