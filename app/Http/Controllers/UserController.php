<?php

namespace App\Http\Controllers;

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
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => ['required', Rule::in(['admin', 'faculty_member', 'student'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);


        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'faculty_member', 'student'])],
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function allProjects()
    {
        $projects = Project::with('creator', 'supervisor', 'members')->get();
        return view('admin.projects.all', compact('projects'));
    }

    public function editProject(Project $project)
    {
        $faculty_members = User::where('role', 'faculty_member')->get();
        $students = User::where('role', 'student')->get();
        return view('admin.projects.edit', compact('project', 'faculty_members', 'students'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['pending_research_cell', 'rejected_research_cell', 'approved_by_research_cell', 'pending_admin_review', 'assigned_to_supervisor', 'in_progress', 'completed', 'cancelled'])],
            'supervisor_id' => ['nullable', 'exists:users,id', Rule::in(User::where('role', 'faculty_member')->pluck('id'))],
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $project->update($request->only(['title', 'description', 'status', 'supervisor_id']));

        if ($request->has('members')) {
            $project->members()->sync($request->members);
        } else {
            $project->members()->detach();
        }

        return redirect()->route('admin.projects.all')->with('success', 'Project updated successfully.');
    }

    public function assignSupervisor(Request $request, Project $project)
    {
        $request->validate([
            'supervisor_id' => ['required', 'exists:users,id', Rule::in(User::where('role', 'faculty_member')->pluck('id'))],
        ]);

        $project->update([
            'supervisor_id' => $request->supervisor_id,
            'status' => 'assigned_to_supervisor',
        ]);

        return back()->with('success', 'Supervisor assigned successfully.');
    }


    public function approve(User $user)
    {
        $user->update(['approved' => true]);
        return redirect()->route('users.index')->with('success', 'User approved successfully.');
    }

}
