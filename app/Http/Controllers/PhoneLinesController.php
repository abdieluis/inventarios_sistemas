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

class PhoneLinesController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    }

    public function index( Request $request ) {

        $data = PhoneLine::select([
            'inventory_phonelines.*',
            'inventory_phonelines.id as action',
        ])
        //->with(['current_equipment_resposnsive',])
        ->addSelect([
            'modality_name' => function( $query ){
                $query->select('name')
                    ->from('inventory_phoneline_modalities')
                    ->whereColumn('inventory_phonelines.modality_id', 'inventory_phoneline_modalities.id')
                    ->limit(1);
            },
        ])
        ->get();

        return Inertia::render('PhoneLines/Index', [
            'data' => $data,
        ]);

    }

    public function create( Request $request ) {
        return Inertia::render('PhoneLines/Create', [
            'db' => [
                'scope' => [ 'Controlada', 'Abierta', 'Prepago' ],
                'companies' => [ 'TELCEL', 'AT&T', 'MEGACABLE' ],
                'modalities' => PhoneLineModality::select(['id','name'])->orderBy('name', 'asc')->get(),
            ],
        ]);
    }


    public function show( Request $request, int $id ) {
           
        $data = PhoneLine::with([
            'modality',
            /*
            'current_responsive' => [
                'employment'  => [
                    'branch',
                    'area',
                    'title',
                    'employee'
                ],
            ]*/
        ])->find($id);

        return Inertia::render('PhoneLines/Show', [
            'data' => $data,
            'db' => [
            ],

        ]);
    }
    
    
    public function store( Request $request ){

        $request->validate([
            'number' => ['required','numeric','unique:App\Models\Inventory\PhoneLine,number', 'max_digits:20'],
            'modality' => ['required','array'],
            'iccid' => ['nullable'],
            'company' => ['required'],
            'scope' => ['required'],
            'notes' => ['nullable'],
        ]);
        
        $row = new PhoneLine;
        $row->modality_id = $request['modality']['id'] ?? NULL;
        $row->number = $request['number'] ?? NULL;

        $row->iccid = $request['iccid'] ?? NULL;
        $row->company = $request['company'] ?? NULL;
        $row->scope = $request['scope'] ?? NULL;
        $row->notes = $request['notes'] ?? NULL;

        $row->created_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('phone-lines.show', $row->id)->with('successMessage', 'Equipment created');
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

        $data = PhoneLine::with([
            'modality',
            /*
            'current_responsive' => [
                'employment'  => [
                    'branch',
                    'area',
                    'title',
                    'employee'
                ],
            ]*/
        ])->find($id);

        return Inertia::render('PhoneLines/Edit', [
            'data' => $data,
            'db' => [
                'scope' => [ 'Controlada', 'Abierta', 'Prepago' ],
                'companies' => [ 'TELCEL', 'AT&T', 'MEGACABLE' ],
                'modalities' => PhoneLineModality::select(['id','name'])->orderBy('name', 'asc')->get(),
            ],

        ]);

    }

    public function update( Request $request, int $id ){

        $request->validate([
            'number' => ['required','numeric', "unique:App\Models\Inventory\PhoneLine,number,$id", 'max_digits:20'],
            'modality' => ['required','array'],
            'iccid' => ['nullable'],
            'company' => ['required'],
            'scope' => ['required'],
            'notes' => ['nullable'],
        ]);
        
        $row = PhoneLine::find($id);
        $row->modality_id = $request['modality']['id'] ?? NULL;
        $row->number = $request['number'] ?? NULL;

        $row->iccid = $request['iccid'] ?? NULL;
        $row->company = $request['company'] ?? NULL;
        $row->scope = $request['scope'] ?? NULL;
        $row->notes = $request['notes'] ?? NULL;

        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro actualizado correctamente"
                ]
            );
            return redirect()->route('phone-lines.show', $row->id)->with('successMessage', 'Equipment created');
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
        $row = PhoneLine::find( $id );
        $row->delete();

        if( $row->isClean() ){
            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Registro eliminado"
                ]
            );
            return redirect()->route('phone-lines');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se pudo elimianr el registro"
                ]
            );
        }

    }

    public function restore( Contact $contact ){
        $contact->restore();
        return Redirect::back()->with('success', 'Contact restored.');
    }

}
