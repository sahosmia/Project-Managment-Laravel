<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProposalRequest;
use App\Models\Project;
use App\Models\Department;
use App\Models\RCell;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ProjectController extends Controller
{

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }


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


        $rcell = RCell::where('research_cell_head', $user->id)->first();

        if ($user->role === 'admin') {
            $projectsQuery->whereIn('status', $validStatuses);
        } elseif ($user->role === 'faculty_member') {
            // $projectsQuery->whereNotIn('status', ['pending_admin', 'rejected_admin']);
            // $projectsQuery->where(function ($query) use ($user, $rcell) {
            //     $query->where('supervisor_id', $user->id)
            //         ->orWhere('cosupervisor_id', $user->id);
            //     if ($rcell) {
            //         $query->orWhere('r_cell_id', $rcell->id);
            //     }
            // });

             $projectsQuery->where(function ($query) use ($user, $rcell) {
                $query->orWhere(function ($q) use ($user) {
                    $q->whereIn('status', ['pending_supervisor', 'rejected_supervisor', 'completed'])
                        ->where(function ($qq) use ($user) {
                            $qq->where('supervisor_id', $user->id)
                                ->orWhere('cosupervisor_id', $user->id);
                        });
                });
                if ($rcell) {
                    $query->orWhere(function ($q) use ($rcell) {
                        $q->where('r_cell_id', $rcell->id)
                            ->whereNotIn('status', ['pending_admin', 'rejected_admin']);
                    });
                }
            });
        } elseif ($user->role === 'student') {
            $projectsQuery->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhereHas('members', function ($query) use ($user) {
                        $query->where('project_members.student_id', $user->id);
                    });
            });
        } else {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to view projects.');
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

        $projectsQuery->with('creator', 'supervisor', 'members', 'rcell.researchCellHead');

        if ($request->has('r_cell_id') && $request->input('r_cell_id') !== null && $request->input('r_cell_id') !== '') {
            $projectsQuery->where('r_cell_id', $request->input('r_cell_id'));
        }

        if ($request->has('semester') && $request->input('semester') !== null && $request->input('semester') !== '') {
            $projectsQuery->where('semester', $request->input('semester'));
        }

        if ($request->has('academic_year') && $request->input('academic_year') !== null && $request->input('academic_year') !== '') {
            $projectsQuery->where('academic_year', $request->input('academic_year'));
        }

        $projectsQuery->orderBy('status')->latest();


        $projects = $projectsQuery->paginate(10)->withQueryString();
        $rcells = RCell::with('researchCellHead')->get();

        return view('projects.index', compact('projects', 'faculty_members', 'rcells',));
    }

    public function create()
    {
        $departments = Department::get();
        $rcells = RCell::with('researchCellHead')->get();
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
            'status' => 'pending_admin',
            'created_by' => Auth::id(),
            'department_id' => $request->department_id,
            'r_cell_id' => $request->rcell_id,
            'supervisor_id' => $request->supervisor_id,
            // 'cosupervisor_id' => $request->cosupervisor_id,
        ]);
        if (count($request->members) > $this->commonService->getSetting('max_member', 5)) {
            return back()->withErrors(['members' => 'You can only add a maximum of ' . $this->commonService->getSetting('max_member', 5) . ' members.'])->withInput();
        }

        foreach ($request->members as $memberData) {
            $project->members()->attach($memberData['user_id']);
        }

        return redirect()->route('projects.index')->with('success', 'Project proposal submitted successfully!');
    }



    public function show(Project $project)
    {
        $project->load('rcell.researchCellHead');

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
            ->get();
        $currentMembers = $project->members->pluck('id')->toArray();
        $departments = Department::get();
        $rcells = RCell::with('researchCellHead')->get();
        $faculty_members = User::where('role', 'faculty_member')->where('approved', true)->get();
        $project->load('rcell.researchCellHead');

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
            'status' => 'pending_admin',
            'notes' => null,
            'department_id' => $request->department_id,
            'r_cell_id' => $request->rcell_id,
            'supervisor_id' => $request->supervisor_id,
            'cosupervisor_id' => $request->cosupervisor_id,
        ]);

        if (count($request->members) > $this->commonService->getSetting('max_member', 5)) {
            return back()->withErrors(['members' => 'You can only add a maximum of ' . $this->commonService->getSetting('max_member', 5) . ' members.'])->withInput();
        }

        $project->members()->sync(array_column($request->members, 'user_id'));



        return redirect()->route('projects.index')->with('success', 'Project updated and re-submitted for review.');
    }


    public function destroy(Project $project)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'You are not authorized to perform this action.');
        }
        $project->delete();

        return back()->with('success', 'Project deleted successfully.');
    }



    public function approve(Project $project)
    {
        $user = auth()->user();
        $rCellHeadedByUser = RCell::where('research_cell_head', $user->id)->first();


        // Admin approval logic
        if ($user->role === 'admin' && $project->status === 'pending_admin') {
            $project->update(['status' => 'pending_research_cell']);
            return back()->with('success', 'Project has been approved by admin.');
        }
        // R-Cell Head approval logic

        if ($rCellHeadedByUser && $project->r_cell_id == $rCellHeadedByUser->id && $project->status === 'pending_research_cell') {

            $project->update(['status' => 'pending_supervisor']);
            return back()->with('success', 'Project has been approved by research cell.');
        }

        // Supervisor approval logic
        if ($user->role === 'faculty_member' && $project->supervisor_id == $user->id && $project->status === 'pending_supervisor') {

            $project->update(['status' => 'completed']);
            return back()->with('success', 'Project has been completed.');
        }

        return abort(403, "You are not authorized to perform this action or the project is not in a valid state for approval.");
    }



    public function reject(Request $request, Project $project)
    {
        $user = auth()->user();
        $request->validate(['notes' => 'required|string']);

        // Admin rejection logic
        if ($user->role === 'admin' && $project->status === 'pending_admin') {
            $project->update(['status' => 'rejected_admin', 'notes' => $request->notes]);
            return back()->with('success', 'Project has been rejected by admin.');
        }

        // R-Cell Head rejection logic
        $rCellHeadedByUser = RCell::where('research_cell_head', $user->id)->first();
        if ($rCellHeadedByUser && $project->r_cell_id == $rCellHeadedByUser->id && $project->status === 'pending_research_cell') {
            $project->update(['status' => 'rejected_research_cell', 'notes' => $request->notes]);
            return back()->with('success', 'Project has been rejected by research cell.');
        }

        // Supervisor rejection logic
        if ($user->role === 'faculty_member' && $project->supervisor_id == $user->id && $project->status === 'pending_supervisor') {
            $project->update(['status' => 'rejected_supervisor', 'notes' => $request->notes]);
            return back()->with('success', 'Project has been rejected by supervisor.');
        }

        return abort(403, "You are not authorized to perform this action or the project is not in a valid state for rejection.");
    }

    public function approveAll(Request $request)
    {
        $projectIds = $request->input('project_ids', []);
        $user = auth()->user();
        $rCellHeadedByUser = RCell::where('research_cell_head', $user->id)->first();


        $projects = Project::whereIn('id', $projectIds)->get();

        foreach ($projects as $project) {
            if ($user->role === 'admin' && $project->status === 'pending_admin') {
                $project->update(['status' => 'pending_research_cell']);
            } elseif ($rCellHeadedByUser && $project->r_cell_id == $rCellHeadedByUser->id && $project->status === 'pending_research_cell') {
                $project->update(['status' => 'pending_supervisor']);
            } elseif ($user->role === 'faculty_member' && $project->supervisor_id == $user->id && $project->status === 'pending_supervisor') {
                    $project->update(['status' => 'completed']);
            }
        }

        return back()->with('success', 'Selected projects have been approved.');
    }

    public function deleteAll(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'You are not authorized to perform this action.');
        }
        $projectIds = $request->input('project_ids', []);
        Project::whereIn('id', $projectIds)->delete();

        return back()->with('success', 'Selected projects have been deleted.');
    }

    public function getSupervisorsByRcell(RCell $rcell)
    {
        $supervisors = User::where('role', 'faculty_member')
            ->where('r_cell_id', $rcell->id)
            ->where('approved', true)
            ->get();

        return response()->json($supervisors);
    }
}
