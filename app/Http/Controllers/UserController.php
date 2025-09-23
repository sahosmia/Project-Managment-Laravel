<?php

namespace App\Http\Controllers;

use App\Models\RCell;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $usersQuery = User::query();

        if ($request->has('name') && $request->input('name') !== null) {
            $usersQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('role') && $request->input('role') !== null && $request->input('role') !== '') {
            $validRoles = ['admin', 'student', 'faculty_member'];
            if (in_array($request->input('role'), $validRoles)) {
                $usersQuery->where('role', $request->input('role'));
            }
        }



        $users = $usersQuery->latest()->paginate(10)->withQueryString();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $rCells = RCell::all();
        return view('users.create', compact('rCells'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => ['required', Rule::in(['admin', 'faculty_member', 'student'])],
            'r_cell_id' => ['nullable', 'exists:r_cells,id'],
            'student_id' => ['nullable'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'r_cell_id' => $request->r_cell_id,
        ]);


        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $rCells = RCell::all();
        return view('users.edit', compact('user', 'rCells'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'faculty_member', 'student'])],
            'r_cell_id' => ['nullable', 'exists:r_cells,id'],
            'student_id' => ['nullable'],
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'r_cell_id' => $request->r_cell_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
