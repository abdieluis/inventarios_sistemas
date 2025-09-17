<?php
namespace App\Http\Controllers\Go;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

use Illuminate\Database\QueryException;
use Illuminate\Validation\Validator;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Inertia\Inertia;
use App\Models\Go\EmploymentTitle;

class EmploymentTitlesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {

        $data = EmploymentTitle::select(['id', 'name', 'id as action'])->get();        
        return Inertia::render('Go/EmploymentTitles/Index', [
            'data' => $data,
        ]);

    }
    public function create() {
        return Inertia::render('Go/EmploymentTitles/Create', [
        ]);
    }

    public function store( Request $request ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Go\EmploymentTitle,name"],
        ]);

        $row = new EmploymentTitle;        
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
            return redirect()->route('employment-titles.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }

        return redirect()->route('go.plantas')->with('success', 'planta creada');

    }

    public function show( Request $request, int $id ){
        $row = EmploymentTitle::find( $id );
        return Inertia::render('Go/EmploymentTitles/Show', [
            'data' => $row,
        ]);
    }

    public function edit( Request $request, int $id ){        
        $row = EmploymentTitle::find( $id );
        return Inertia::render('Go/EmploymentTitles/Edit', [
            'data' => $row,
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Go\EmploymentTitle,name,$id"],
        ]);
        
        $row = EmploymentTitle::find( $id );
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
            return redirect()->route('employment-titles.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = EmploymentTitle::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('employment-titles');
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
