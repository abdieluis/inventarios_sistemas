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

use App\Models\Inventory\PhoneLine;
use App\Models\Inventory\PhoneLineModality;

class PhoneLineModalitiesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    }

    public function index( Request $request ) {

        $data = PhoneLineModality::select(['id', 'name', 'id as action'])->get();
        return Inertia::render('PhoneLineModalities/Index', [
            'data' => $data,
        ]);
        
    }

    public function create( Request $request ) {
        return Inertia::render('PhoneLineModalities/Create', [
            'db' => [
            ],
        ]);
    }


    public function show( Request $request, int $id ) {
        $data = PhoneLineModality::find($id);
        return Inertia::render('PhoneLineModalities/Show', [
            'data' => $data,
            'db' => [],
        ]);
    }
    
    
    public function store( Request $request ){
        
        $request->validate([
            'name' => ['required','unique:App\Models\Inventory\PhoneLineModality,name'],
        ]);
        
        $row = new PhoneLineModality;
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
            return redirect()->route('phone-line-modalities.show', $row->id)->with('successMessage', 'PhoneLineModality');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
        }
    }

    public function edit( Request $request, int $id ){
        $data = PhoneLineModality::find($id);
        return Inertia::render('PhoneLineModalities/Edit', [
            'data' => $data,
            'db' => [],
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Inventory\PhoneLineModality,name,$id"],
        ]);
        
        $row = PhoneLineModality::find( $id );
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
            return redirect()->route('phone-line-modalities.show', $row->id)->with('successMessage', 'Equipment created');
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

        $row = PhoneLineModality::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('phone-line-modalities');
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
