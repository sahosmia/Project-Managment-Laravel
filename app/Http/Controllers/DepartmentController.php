<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{

      public function index(Request $request)
    {
        $departmentsQuery = Department::query();

        if ($request->has('name') && $request->input('name') !== null) {
            $departmentsQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('role') && $request->input('role') !== null && $request->input('role') !== '') {
            $validRoles = ['admin', 'student', 'supervisor', 'research_cell'];
            if (in_array($request->input('role'), $validRoles)) {
                $departmentsQuery->where('role', $request->input('role'));
            }
        }

        $departments = $departmentsQuery->paginate(10)->withQueryString();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
       $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Department::create($validate);


        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
       $validate = $request->validate([
            'description' => 'nullable|string',
            'name' => 'required|string|max:255',

        ]);

        $department->update($validate);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
