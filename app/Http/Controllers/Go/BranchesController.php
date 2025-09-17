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
use App\Models\Go\Branch;

class BranchesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {
        
        $data = Branch::select(['id', 'name', 'id as action'])
        ->addSelect([
            //DB::raw("DATE_FORMAT(ps_core_calendar.date, '%Y-%m-%d') as group_by"),
            'employees_count' => function( $query ){
                $query->select( DB::raw("COUNT(employee_id)") )
                    ->from('go_employments')
                    ->whereColumn('branch_id', 'go_branches.id')
                    ->limit(1);
            },
        ])
        ->get();

        return Inertia::render('Go/Branches/Index', [
            'data' => $data,
        ]);
    
    }
    public function create() {
        return Inertia::render('Go/Branches/Create', [
        ]);
    }

    public function store( Request $request ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Go\Branch,name"],
        ]);

        $row = new Branch;        
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
            return redirect()->route('branches.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = Branch::find( $id );
        return Inertia::render('Go/Branches/Show', [
            'data' => $row,
        ]);
    }

    public function edit( Request $request, int $id ){
        $data = Branch::find($id);
        return Inertia::render('Go/Branches/Edit', [
            'data' => $data,
        ]);
    }

    public function update( Request $request, int $id ){

        $request->validate([
            'name' => ["required", "unique:App\Models\Go\Branch,name,$id"],
        ]);
        
        $row = Branch::find( $id );
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
            return redirect()->route('branches.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = Branch::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('branches');
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
