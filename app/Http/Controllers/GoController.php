<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\URL;

use Inertia\Inertia;

use App\Models\Employee;

class GoController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
    }

    public function index( Request $request ) {
        
        return Inertia::render('Go/Index', [              
        ]);
    }

}
