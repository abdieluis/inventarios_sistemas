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

use App\Exports\{
    UsersExport,
    EmployeesExport,
    PhonelinesExport,
    EquipmentsExport,
    ResponsivesExport
};

use Inertia\Inertia;

use Excel;


use App\Models\Inventory\EquipmentFeature;
use App\Models\Inventory\Equipment;


class ReportsController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    } 

    public function index( Request $request ) {
        return Inertia::render('Reports/Index', [
            'db' => [
            ],
        ]);
    }

    public function users( Request $request ) {
        $filename = 'usuarios ' . date_format(date_create(), 'Y-m-d') . '.xlsx';
        return Excel::download( new UsersExport, $filename );
    }

    public function employees( Request $request ) {
        $filename = 'empleados ' . date_format(date_create(), 'Y-m-d') . '.xlsx';
        return Excel::download( new EmployeesExport, $filename );
    }

    public function equipments( Request $request ) {        
        $filename = 'equipos ' . date_format(date_create(), 'Y-m-d') . '.xlsx';
        return Excel::download( new EquipmentsExport, $filename );
    }

    public function responsives( Request $request ) {
        $filename = 'responsivas ' . date_format(date_create(), 'Y-m-d') . '.xlsx';
        return Excel::download( new ResponsivesExport, $filename );
    }
    
    public function phonelines( Request $request ) {
        $filename = 'lineas-telefonicas ' . date_format(date_create(), 'Y-m-d') . '.xlsx';
        return Excel::download( new PhonelinesExport, $filename );
    }

}
