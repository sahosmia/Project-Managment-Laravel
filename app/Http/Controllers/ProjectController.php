<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProposalRequest;
use App\Models\Project;
use App\Models\Department;
use App\Models\RCell;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $projectsQuery = Project::query();
        $user = Auth::user();
        $faculty_members = User::where('role', 'faculty_member')->where('approved', true)->get();
        $validStatuses = [
            'pending_research_cell',
            'rejected_research_cell',
            'pending_admin',
            'rejected_admin',
            'pending_supervisor',
            'rejected_supervisor',
            'completed',
        ];


        switch ($user->role) {
            case 'admin':
                $projectsQuery->whereIn('status', $validStatuses);
                break;
            case 'faculty_member':
                $projectsQuery->where('supervisor_id', $user->id)
                    ->orWhere('cosupervisor_id', $user->id);
                break;
            case 'student':
                $projectsQuery->where(function ($q) use ($user) {
                    $q->where('created_by', $user->id)
                        ->orWhereHas('members', function ($query) use ($user) {
                            $query->where('project_members.student_id', $user->id);
                        });
                });
                break;
            default:
                abort(Response::HTTP_FORBIDDEN, 'You do not have permission to view projects.');
                break;
        }

        if ($request->has('title') && $request->input('title') !== null) {
            $projectsQuery->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('status') && $request->input('status') !== null && $request->input('status') !== '') {


            if (in_array($request->input('status'), $validStatuses)) {
                $projectsQuery->where('status', $request->input('status'));
            }
        }

        if (($user->role == 'admin') && $request->has('supervisor_id') && $request->input('supervisor_id') !== null && $request->input('supervisor_id') !== '') {
            $projectsQuery->where('supervisor_id', $request->input('supervisor_id'));
        }



        $projectsQuery->with('creator', 'supervisor', 'members');

        $projectsQuery->orderBy('status')->latest();


        $projects = $projectsQuery->paginate(10)->withQueryString();

        return view('projects.index', compact('projects', 'faculty_members'));
    }

    public function create()
    {
        $departments = Department::get();
        $rcells = RCell::get();
        $students = User::where('role', 'student')
            ->where('approved', true)
            ->whereDoesntHave('createdProjects')
            ->whereDoesntHave('memberOfProjects')
            ->get();
        $faculty_members = User::where('role', 'faculty_member')->where('approved', true)->get();
        return view('projects.create', compact('students', 'departments', 'rcells', 'faculty_members'));
    }

    public function store(StoreProposalRequest $request)
    {

        $project = Project::create([
            'title' => $request->proposed_title,
            'academic_year' => $request->academic_year,
            'course_title' => $request->course_title,
            'course_code' => $request->course_code,
            'problem_statement' => $request->problem_statement,
            'motivation' => $request->motivation,
            'course_type' => $request->course_type,
            'semester' => $request->semester,
            'status' => 'pending_research_cell',
            'created_by' => Auth::id(),
            'department_id' => $request->department_id,
            'r_cell_id' => $request->rcell_id,
            'supervisor_id' => $request->supervisor_id,
            'cosupervisor_id' => $request->cosupervisor_id,
        ]);
        if (count($request->members) > get_setting('max_member', 5)) {
            return back()->withErrors(['members' => 'You can only add a maximum of ' . get_setting('max_member', 5) . ' members.'])->withInput();
        }

        foreach ($request->members as $memberData) {
            $project->members()->attach($memberData['user_id']);
        }

        return redirect()->route('projects.index')->with('success', 'Project proposal submitted successfully!');
    }



    public function show(Project $project)
    {
        $faculty_members = User::where('role', 'faculty_member')->where('approved', true)->get();
        return view('projects.show', compact('project', 'faculty_members'));
    }

    public function edit(Project $project)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            $rejectedStatuses = ['rejected_research_cell', 'rejected_admin', 'rejected_supervisor'];
            if ($project->created_by !== $user->id || !in_array($project->status, $rejectedStatuses)) {
                abort(403, 'You can only edit rejected projects that you created.');
            }
        }

 $currentMemberIds = $project->members->pluck('id');
        $students = User::where('role', 'student')
            ->where('approved', true)
            ->where(function ($query) use ($currentMemberIds) {
                $query->whereDoesntHave('createdProjects')
                    ->whereDoesntHave('memberOfProjects')
                    ->orWhereIn('id', $currentMemberIds);
            })
            ->get();        $currentMembers = $project->members->pluck('id')->toArray();
        $departments = Department::get();
        $rcells = RCell::get();
        $faculty_members = User::where('role', 'faculty_member')->where('approved', true)->get();
        return view('projects.edit', compact('project', 'students', 'currentMembers', 'departments', 'rcells', 'faculty_members'));
    }

    public function update(StoreProposalRequest $request, Project $project)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            $rejectedStatuses = ['rejected_research_cell', 'rejected_admin', 'rejected_supervisor'];
            if ($project->created_by !== $user->id || !in_array($project->status, $rejectedStatuses)) {
                abort(403, 'You can only update rejected projects that you created.');
            }
        }



        $project->update([
            'title' => $request->proposed_title,
            'academic_year' => $request->academic_year,
            'course_title' => $request->course_title,
            'course_code' => $request->course_code,
            'problem_statement' => $request->problem_statement,
            'motivation' => $request->motivation,
            'course_type' => $request->course_type,
            'semester' => $request->semester,
            'status' => 'pending_research_cell',
            'notes' => null,
            'department_id' => $request->department_id,
            'r_cell_id' => $request->rcell_id,
            'supervisor_id' => $request->supervisor_id,
            'cosupervisor_id' => $request->cosupervisor_id,
        ]);

         if (count($request->members) > get_setting('max_member', 5)) {
            return back()->withErrors(['members' => 'You can only add a maximum of ' . get_setting('max_member', 5) . ' members.'])->withInput();
        }

        $project->members()->sync(array_column($request->members, 'user_id'));



        return redirect()->route('projects.index')->with('success', 'Project updated and re-submitted for review.');
    }


    public function destroy(Project $project)
    {

        $project->delete();

        return back()->with('success', 'Project deleted successfully.');
    }



    public function approve(Project $project)
    {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                if ($project->status === 'pending_admin') {
                    $project->update(['status' => 'completed']);
                    return back()->with('success', 'Project has been completed.');
                }
                break;
            case 'faculty_member':
                if ($project->status === 'pending_supervisor') {
                    $project->update(['status' => 'completed']);
                    return back()->with('success', 'Project has been completed.');
                }
                break;
        }

        abort(403, "You are not authorized to perform this action or the project is not in a valid state for approval.");
    }



    public function reject(Request $request, Project $project)
    {
        $user = auth()->user();

        $request->validate(['notes' => 'required|string']);

        switch ($user->role) {
            case 'admin':
                if ($project->status === 'pending_admin') {
                    $project->update(['status' => 'rejected_admin', 'notes' => $request->notes]);
                    return back()->with('success', 'Project has been rejected by admin.');
                }
                break;
            case 'faculty_member':
                if ($project->status === 'pending_supervisor') {
                    $project->update(['status' => 'rejected_supervisor', 'notes' => $request->notes]);
                    return back()->with('success', 'Project has been rejected by supervisor.');
                }
                break;
        }

        abort(403, "You are not authorized to perform this action or the project is not in a valid state for rejection.");
    }
}
