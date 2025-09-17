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

use App\Models\Inventory\ResponsiveEnding;

class ResponsiveEndingsController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    }

    public function index( Request $request ) {

        $data = ResponsiveEnding::select(['id', 'name', 'id as action'])->get();
        return Inertia::render('ResponsiveEndings/Index', [
            'data' => $data,
        ]);

    }

    public function create( Request $request ) {
        return Inertia::render('ResponsiveEndings/Create', [
            'db' => [
            ],
        ]);
    }


    public function show( Request $request, int $id ) {
        $data = ResponsiveEnding::find($id);
        return Inertia::render('ResponsiveEndings/Show', [
            'data' => $data,
            'db' => [],
        ]);
    }
    
    public function store( Request $request ){
        
        $request->validate([
            'name' => ['required','unique:App\Models\Inventory\ResponsiveEnding,name'],
        ]);
        
        $row = new ResponsiveEnding;
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
            return redirect()->route('responsive-endings.show', $row->id)->with('successMessage', 'Equipment created');
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
        $data = ResponsiveEnding::find($id);
        return Inertia::render('ResponsiveEndings/Edit', [
            'data' => $data,
            'db' => [],
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Inventory\ResponsiveEnding,name,$id"],
        ]);
        
        $row = ResponsiveEnding::find( $id );
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
            return redirect()->route('responsive-endings.show', $row->id)->with('successMessage', 'Equipment created');
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

        $row = ResponsiveEnding::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('responsive-endings', $row->id);
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
