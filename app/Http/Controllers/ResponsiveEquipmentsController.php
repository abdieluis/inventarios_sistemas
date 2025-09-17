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

use App\Models\Inventory\Responsive;
use App\Models\Inventory\ResponsiveEquipment;
use App\Models\Inventory\EquipmentCategory;
use App\Models\Inventory\EquipmentBrand;
use App\Models\Inventory\Equipment;
use App\Models\Inventory\EquipmentAccessory;

use App\Models\Go\Employee;
use App\Models\Go\Employment;


class ResponsiveEquipmentsController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    }

    public function index( Request $request, int $responsive_id ) {
    }

    public function create( Request $request, int $responsive_id ) {

    }
    
    public function store( Request $request, int $responsive_id ){
    }

    public function show( Request $request, int $responsive_id, int $id ){
    }

    public function edit( Request $request, int $responsive_id, int $id ){
    }

    public function destroy( Request $request, int $responsive_id, int $id ){
    }

    public function restore( Request $request, int $responsive_id, int $id ){
    }

    public function create_promissory_note( Request $request, int $responsive_id, int $id ){

        $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        $row = ResponsiveEquipment::find( $id );
        $row->amount = $request['amount'];

        $row->updated_by = $request->user()->id;
        $row->save();

        if( $row->isClean() ){

            session()->flash(
                'flash', [
                    'status' => "success",
                    'message' => "Pagaré creado correctamente"
                ]
            );
            return redirect()->route('responsives.show', $row->responsive_id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash', [
                    'status' => "error",
                    'message' => "No se creo el registro"
                ]
            );
        }        

    }

    public function update_phone_line( Request $request, int $responsive_id, int $id, int $new_phone_id, int $old_phone_id ){

        // dd($request->all(), $responsive_id, $id, $old_phone_id, $new_phone_id);

        $request->validate([
            'phone' => ['required', 'integer']
        ]);

        $row = ResponsiveEquipment::find( $id );
        $row->phoneline_id = $request['phone'];

        $row->updated_by = $request->user()->id;
        $row->save();

        $old_phone = \App\Models\Inventory\PhoneLine::find( $old_phone_id );
        if( $old_phone ){
            $old_phone->status = 'Disponible';
            $old_phone->updated_by = $request->user()->id;
            $old_phone->save();
        }

        $new_phone = \App\Models\Inventory\PhoneLine::find( $new_phone_id );
        if( $new_phone ){
            $new_phone->status = 'Asignada';
            $new_phone->updated_by = $request->user()->id;
            $new_phone->save();
        }

        // if( $row->isClean() ){

        //     session()->flash(
        //         'flash', [
        //             'status' => "success",
        //             'message' => "Pagaré creado correctamente"
        //         ]
        //     );
        return redirect()->route('responsives.show', $row->responsive_id)->with('successMessage', 'Equipment created');
        // } else {
        //     session()->flash(
        //         'flash', [
        //             'status' => "error",
        //             'message' => "No se creo el registro"
        //         ]
        //     );
        // }        

    }


    public function print_promissory_note( Request $request, int $responsive_id, int $id ) {

        $data = ResponsiveEquipment::with([
            'data' => ['category','brand','model',],
            'responsive' => [
                'employment' => ['branch','area','title', 'employee'],
                'employments' => [
                    'data' => [
                        'branch',
                        'area',
                        'title',
                        'employee'
                    ]
                ],
    
            ],
        ])->find($id);

        $pdf = \PDF::loadView( 'responsives.print-format-promissory-note', [
            'data' => $data 
        ]);
        return $pdf->stream();
    }
    public function download_promissory_note( Request $request, int $responsive_id, int $id ) {

        $filename = "responsiva de equipo - $id.pdf";

        $data = ResponsiveEquipment::with([
            'data' => ['category','brand','model',],
            'responsive' => [
                'employment' => ['branch','area','title', 'employee'],
                'employments' => [
                    'data' => [
                        'branch',
                        'area',
                        'title',
                        'employee'
                    ]
                ],
    
            ],
        ])->find($id);

        $pdf = \PDF::loadView( 'responsives.print-format-promissory-note', [
            'data' => $data 
        ] );
        return $pdf->download( $filename );

    }

    
}
