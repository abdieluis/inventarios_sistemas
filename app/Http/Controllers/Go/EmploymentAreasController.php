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
use App\Models\Go\EmploymentArea;


class EmploymentAreasController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {
        $data = EmploymentArea::select(['id', 'name', 'id as action'])->get();        
        return Inertia::render('Go/EmploymentAreas/Index', [
            'data' => $data,
        ]);
    }
    public function create() {
        return Inertia::render('Go/EmploymentAreas/Create', [
        ]);
    }

    public function store( Request $request ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Go\EmploymentArea,name"],
        ]);

        $row = new EmploymentArea;
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
            return redirect()->route('employment-areas.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = EmploymentArea::find( $id );
        return Inertia::render('Go/EmploymentAreas/Show', [
            'data' => $row,
        ]);
    }

    public function edit( Request $request, int $id ){        
        $row = EmploymentArea::find( $id );
        return Inertia::render('Go/EmploymentAreas/Edit', [
            'data' => $row,
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Go\EmploymentArea,name,$id"],
        ]);
        
        $row = EmploymentArea::find( $id );
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
            return redirect()->route('employment-areas.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = EmploymentArea::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('employment-areas');
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
