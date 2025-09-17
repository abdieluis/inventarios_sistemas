<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Inertia\Inertia;

use App\Models\User;

class UsersController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $response;

    function __construct() {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index( Request $request ) {
        
        return Inertia::render('Users/Index', [
            'data' => User::all(),              
        ]);

        /*
        return Inertia::render('Users', [
            'data' => User::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'edit_url' => URL::route('user.edit', $users),
                ];
            }),
            'create_url' => URL::route('users.create'),
        ]);
        */
    
    }
    public function create() {
        return Inertia::render('Users/Create', [
            /*
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            */
        ]);
    }

    public function store( Request $request ){
        
        /*
        Request::validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
        ]);

        */

        $row = new User;
        
        $row->name = $request['name'] ?? '';
        $row->email = $request['email'] ?? '';
        $row->password = $request['password'] ?? '';

        $row->save();

        if( $row->isClean() ){
            // success
        } else {
            // error
        }

        return redirect()->route('users')->with('success', 'Usuario Creado');

    }

    public function edit( Contact $contact ){
        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'organization_id' => $contact->organization_id,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'city' => $contact->city,
                'region' => $contact->region,
                'country' => $contact->country,
                'postal_code' => $contact->postal_code,
                'deleted_at' => $contact->deleted_at,
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update( Contact $contact ){
        $contact->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => [
                    'nullable',
                    Rule::exists('organizations', 'id')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id)),
                ],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );
        return Redirect::back()->with('success', 'Contact updated.');
    }

    public function destroy( Contact $contact ){
        $contact->delete();
        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore( Contact $contact ){
        $contact->restore();
        return Redirect::back()->with('success', 'Contact restored.');
    }

}
