<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
   

    public function createProject()
    {
        $students = User::where('role', 'student')->get();
        return view('student.projects.create', compact('students'));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'status' => 'pending_research_cell',
        ]);

        $project->members()->sync(array_merge([Auth::id()], $request->members));

        return redirect()->route('student.projects.my')->with('success', 'Project created and submitted for review.');
    }


    public function myProjects()
    {
        $projects = Project::where('created_by', Auth::id())
                            ->orWhereHas('members', function ($query) {
                                $query->where('student_id', Auth::id());
                            })
                            ->with('creator', 'supervisor', 'members')
                            ->get();
        return view('student.projects.my', compact('projects'));
    }

    public function editProject(Project $project)
    {
        if ($project->created_by !== Auth::id() || $project->status !== 'rejected_by_research_cell') {
            abort(403, 'You can only edit rejected projects that you created.');
        }
        $students = User::where('role', 'student')->get();
        $currentMembers = $project->members->pluck('id')->toArray();
        return view('student.projects.edit', compact('project', 'students', 'currentMembers'));
    }

    public function updateProject(Request $request, Project $project)
    {
        if ($project->created_by !== Auth::id() || $project->status !== 'rejected_by_research_cell') {
            abort(403, 'You can only update rejected projects that you created.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending_research_cell',
        ]);

        $project->members()->sync(array_merge([Auth::id()], $request->members));

        return redirect()->route('student.projects.my')->with('success', 'Project updated and re-submitted for review.');
    }




}
