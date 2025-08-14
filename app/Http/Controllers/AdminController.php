<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
   
    public function assignSupervisor(Request $request, Project $project)
    {
        $request->validate([
            'supervisor_id' => ['required', 'exists:users,id', Rule::in(User::where('role', 'supervisor')->pluck('id'))],
        ]);

        $project->update([
            'supervisor_id' => $request->supervisor_id,
            'status' => 'assigned_to_supervisor', 
        ]);

        return back()->with('success', 'Supervisor assigned successfully.');
    }
}
