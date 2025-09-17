<?php

namespace App\Http\Controllers\Go;

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

use App\Models\Go\Employee;
use App\Models\Go\Branch;
use App\Models\Go\Employment;
use App\Models\Go\EmploymentArea;
use App\Models\Go\EmploymentTitle;


class EmployeesController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $response;

    function __construct()
    {
        $this->response = [
            'base_url' => "/trading/sales",
            'render' => "",
        ];
    }

    public function index(Request $request)
    {

        /*
        $data = Employee::select([
            'go_employees.*',
            'go_employees.id as action',
            'go_employments.branch_id',
            'go_employments.area_id',
            'go_employments.title_id',
        ])
        ->leftJoin(
            'go_employments',
            'go_employments.employee_id',
            '=',
            'go_employees.id',
        )
        ->addSelect([
            'branch_name' => function( $query ){
                $query->select('name')
                    ->from('go_branches')
                    ->whereColumn('go_employments.branch_id', 'go_branches.id')
                    ->limit(1);
            },
            'area_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_areas')
                    ->whereColumn('go_employments.area_id', 'go_employment_areas.id')
                    ->limit(1);
            },
            'title_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_titles')
                    ->whereColumn('go_employments.title_id', 'go_employment_titles.id')
                    ->limit(1);
            },
        ])
        ->whereNull( 'end_at' )
        ->get();
        */

        /*
        $data = Employee::select([
            'go_employees.*',
            'go_employees.id as action',
            'go_employments.branch_id',
            'go_employments.area_id',
            'go_employments.title_id',
        ])
        ->leftJoin(
            'go_employments',
            'go_employments.employee_id',
            '=',
            'go_employees.id',
        )
        ->addSelect([
            'branch_name' => function( $query ){
                $query->select('name')
                    ->from('go_branches')
                    ->whereColumn('go_employments.branch_id', 'go_branches.id')
                    ->limit(1);
            },
            'area_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_areas')
                    ->whereColumn('go_employments.area_id', 'go_employment_areas.id')
                    ->limit(1);
            },
            'title_name' => function( $query ){
                $query->select('name')
                    ->from('go_employment_titles')
                    ->whereColumn('go_employments.title_id', 'go_employment_titles.id')
                    ->limit(1);
            },
            'equipments_count' => function( $query ){
                $query->selectRaw('count(id)')
                    ->from('go_employments')
                    ->whereNull('go_employments.end_at')
                    ->whereColumn('go_employments.employee_id', 'go_employees.id');
            },
        ])
        ->whereNull( 'end_at' )
        ->whereNull([ 'end_at', ])
        ->get();
        */

        $data = Employee::select([
            'go_employees.*',
            'go_employees.id as action',
        ])
            ->with([
                'current_employment' => [
                    'branch',
                    'area',
                    'title',
                ]
            ])
            ->get();


        return Inertia::render('Go/Employees/Index', [
            'data' => $data,
        ]);

        /*
        return Inertia::render('Employees', [
            'data' => Employee::all()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'edit_url' => URL::route('employees.edit', $employee),
                ];
            }),
            'create_url' => URL::route('employees.create'),
        ]);
        */
    }

    public function create()
    {

        return Inertia::render('Go/Employees/Create', [
            'db' => [
                'branches' => Branch::select(['id', 'name'])->orderBy('name', 'asc')->get(),
                'employmentAreas' => EmploymentArea::select(['id', 'name'])->orderBy('name', 'asc')->get(),
                'employmentTitles' => EmploymentTitle::select(['id', 'name'])->orderBy('name', 'asc')->get(),
            ],

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

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'employee_number' => ['nullable', 'numeric', 'unique:App\Models\Go\Employee,employee_number'],
            'phone' => ['nullable', 'numeric'],
            'address' => ['nullable'],

            'file_id' => ['nullable', 'file'],
            'file_address' => ['nullable', 'file'],
        ]);

        $row = new Employee;

        $row->first_name = $request['first_name'] ?? NULL;
        $row->last_name = $request['last_name'] ?? NULL;
        $row->employee_number = $request['employee_number'] ?? NULL;
        $row->phone = $request['phone'] ?? NULL;
        $row->address = $request['address'] ?? NULL;

        // $row->file_id = $request['file_id'] ?? NULL;
        // $row->file_address = $request['file_address'] ?? NULL;

        $row->created_by = $request->user()->id;
        $row->save();

        /* save files */
        $files = [
            'id' => null,
            'address' => null,
        ];

        $dir_name = "$row->id - $row->first_name $row->last_name";

        if (!empty($request->file_id)) {
            $files['id'] = $request->file_id->storeAs(
                $dir_name,
                "id." . $request->file_id->extension()
            );
        }

        if (!empty($request->file_address)) {
            $files['address'] = $request->file_address->storeAs(
                $dir_name,
                "domicilio." . $request->file_address->extension()
            );
        }

        $row->files = $files;
        $row->save();


        if ($row->isClean()) {
            session()->flash(
                'flash',
                [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('employees.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash',
                [
                    'status' => "error",
                    'message' => "No se creó el registro"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }

        //return redirect()->route('employees')->with('success', 'employee created');

    }

    public function show(Request $request, int $id)
    {

        $data = Employee::with([
            'current_employment' => [
                'branch',
                'area',
                'title',
                'responsives' => [
                    'equipments' => [
                        'data' => ['category', 'brand', 'owner']
                    ],
                ],
            ],
            'employments' => [
                'branch',
                'area',
                'title',
                'responsives' => [
                    'equipments' => [
                        'data' => ['category', 'brand', 'owner']
                    ],
                ],
            ]
        ])->find($id);

        if (isset($data->files['id'])) {
            Storage::url($data->files['id']);
        }

        if (isset($data->files['address'])) {
            Storage::url($data->files['address']);
        }

        $allTitles = EmploymentTitle::all();

        return Inertia::render('Go/Employees/Show', [
            'data' => $data,
            'allTitles' => $allTitles,
        ]);
    }

    public function edit(Request $request, int $id)
    {
        return Inertia::render('Go/Employees/Edit', [
            'data' => Employee::find($id),
        ]);
    }

    public function update(Request $request, int $id)
    {

        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'employee_number' => ['nullable', 'numeric', "unique:App\Models\Go\Employee,employee_number,$id"],
            'phone' => ['nullable', 'numeric'],
            'address' => ['nullable'],

            'file_id' => ['nullable', 'file'],
            'file_address' => ['nullable', 'file'],
        ]);

        $row = Employee::find($id);

        $row->first_name = $request['first_name'] ?? NULL;
        $row->last_name = $request['last_name'] ?? NULL;
        $row->employee_number = $request['employee_number'] ?? NULL;
        $row->phone = $request['phone'] ?? NULL;
        $row->address = $request['address'] ?? NULL;

        // $row->file_id = $request['file_id'] ?? NULL;
        // $row->file_address = $request['file_address'] ?? NULL;

        $row->updated_by = $request->user()->id;
        $row->save();

        /* save files */
        $files = [
            'id' => null,
            'address' => null,
        ];

        $dir_name = "$row->id - $row->first_name $row->last_name";

        if (!empty($request->file_id)) {
            $files['id'] = $request->file_id->storeAs(
                $dir_name,
                "id." . $request->file_id->extension()
            );
        }

        if (!empty($request->file_address)) {
            $files['address'] = $request->file_address->storeAs(
                $dir_name,
                "domicilio." . $request->file_address->extension()
            );
        }

        $row->files = $files;
        $row->save();


        if ($row->isClean()) {
            session()->flash(
                'flash',
                [
                    'status' => "success",
                    'message' => "Registro actualizado correctamente"
                ]
            );
            return redirect()->route('employees.show', $row->id)->with('successMessage', 'Equipment created');
        } else {
            session()->flash(
                'flash',
                [
                    'status' => "error",
                    'message' => "No se actualizó el registro"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }
    }

    public function destroy(Request $request, int $id)
    {
        Employee::destroy($id);
        return redirect()->route('employees')->with('successMessage', 'Equipment created');
    }

    public function restore(Request $request, int $id) {}


}
