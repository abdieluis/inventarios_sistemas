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

class EmploymentsController extends Controller
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

    public function index(Request $request, int $employee)
    {
        // Carga la lista de empleados con sus relaciones
        $employees = Employee::with([
            'current_employment' => function ($query) {
                $query->with(['branch', 'area', 'title']);
            }
        ])->get();

        // Obtiene todos los títulos de los puestos de trabajo de la base de datos
        $employmentTitles = EmploymentTitle::all();

        // Retorna la vista de Inertia con los datos de empleados y los títulos
        return Inertia::render('Go/Employees/Employments/Index', [
            'data' => $employees,
            'employmentTitles' => $employmentTitles,
        ]);
    }

    public function create(Request $request, int $employee)
    {

        return Inertia::render('Go/Employees/Employments/Create', [
            'data' => Employee::find($employee),
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

    public function store(Request $request, int $employee_id)
    {

        $request->validate([
            'branch' => ['required', 'array'],
            'area' => ['required', 'array'],
            'title' => ['required', 'array'],
            'start_at' => ['required'],
        ]);

        $row = new Employment;

        $row->employee_id = $employee_id;
        $row->branch_id = $request['branch']['id'] ?? NULL;
        $row->area_id = $request['area']['id'] ?? NULL;
        $row->title_id = $request['title']['id'] ?? NULL;
        $row->start_at = $request['start_at'] ?? NULL;

        $row->updated_by = $request->user()->id;

        $employee = Employee::find($employee_id);
        if ($employee->current_employment == NULL) {
            $row->save();
        }


        if ($row->isClean()) {
            session()->flash(
                'flash',
                [
                    'status' => "success",
                    'message' => "Registro creado correctamente"
                ]
            );
            return redirect()->route('employees.show', $employee_id);
        } else {
            session()->flash(
                'flash',
                [
                    'status' => "error",
                    'message' => "El empleado ya tiene un cargo laboral vigente"
                ]
            );
            //return redirect()->route('equipments.show', $row->id)->with('success', 'Equipment created');
        }
    }

    public function show(Request $request, int $employee, int $id)
    {
        return Inertia::render('Go/Employees/Employments/Show', [
            'data' => Employee::find($employee)->employments->find($id),
            'employee' => Employee::find($employee),
        ]);
    }

    public function edit(Request $request, int $employee, int $id)
    {
        return Inertia::render('Go/Employees/Employments/Edit', [
            'data' => Employee::find($employee)->employments->find($id),
            'employee' => Employee::find($employee),
        ]);
    }

    public function update(Request $request, int $employee)
    {
        // ...
        $request->validate([
            'title_id' => 'required|exists:go_employment_titles,id',
        ]);

        $employeeObject = Employee::find($employee);

        if (!$employeeObject) {
            // Manejar el caso si el empleado no se encuentra
            session()->flash('flash', [
                'status' => 'error',
                'message' => 'Empleado no encontrado.',
            ]);
            return redirect()->back();
        }

        // 3. Localizar el registro de empleo más reciente
        $currentEmployment = $employeeObject->current_employment;

        if ($currentEmployment) {
            // 4. Actualizar el title_id en el registro de empleo
            $currentEmployment->title_id = $request->title_id;
            $currentEmployment->save();

            session()->flash('flash', [
                'status' => 'success',
                'message' => 'Puesto laboral actualizado correctamente.',
            ]);

            // 5. Redireccionar al perfil del empleado
            return redirect()->route('employees.show', $employeeObject->id);
        }

        // 6. Si no hay empleo vigente, establecer el mensaje de error y redireccionar
        session()->flash('flash', [
            'status' => 'error',
            'message' => 'El empleado no tiene un cargo laboral vigente.',
        ]);

        return redirect()->route('employees.show', $employeeObject->id);
    }

    public function destroy(Request $request, int $employee, int $id) {}

    public function restore(Request $request, int $employee, int $id) {}
}
