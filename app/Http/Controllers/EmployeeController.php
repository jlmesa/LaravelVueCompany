<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Inertia\Inertia;
use Illuminate\Http\Request;
use DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::select('employees.*', 'departments.name as department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')->paginate(10);

        $departments = Department::all();

        return Inertia::render('Employees/Index', ['employees' => $employees, 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ]);

        $employee = New Employee($request->input());
        $employee->save();
        return redirect('employees');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ]);
        $employee->update($request->input());
        return redirect('employees');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function EmployeeByDepartment(){
        $data = Employee::select(DB::raw('count(employees.id) as count, departments.name'))
        ->join('departments', 'departments.id','=','employees.department_id')->groupBy('departments.name')->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports(){
        $employees = Employee::select('employees.*', 'departments.name as department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')->get();

        $departments = Department::all();

        return Inertia::render('Employees/Reports', ['employees' => $employees, 'departments' => $departments]);
    }
}
