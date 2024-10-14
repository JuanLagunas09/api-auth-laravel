<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Departament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::select('employees.*', 'departaments.name as departament_name')
            ->join('departaments', 'employees.departament_id', '=', 'departaments.id')
            ->paginate(10);
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:15',
            'departament_id' => 'required|integer|exists:departaments,id'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $employee = new Employee($request->all());
        $employee->save();
        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee, 200);
    }

    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:15',
            'departament_id' => 'required|integer|exists:departaments,id'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $employee->update($request->all());
        return response()->json($employee, 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }

    public function employeesByDepartament()
    {
        $employees = Employee::select(
            DB::raw('count(employees.id) as total_employees'),
            'departaments.name as departament_name'
        )
        ->join('departaments', 'employees.departament_id', '=', 'departaments.id')
        ->groupBy('departament_name')
        ->get();
        return response()->json($employees);
    }

    public function all()
    {
        $employees = Employee::select(
            DB::raw('count(employees.id) as total_employees'),
            'departaments.name as departament_name'
        )
        ->join('departaments', 'employees.departament_id', '=', 'departaments.id')
        ->get();
        return response()->json($employees);
    }
}
