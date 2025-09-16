<?php

namespace App\Http\Controllers;

use App\Models\IndustrialProposal;
use App\Models\User;
use App\Models\Project;
use App\Models\RCell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_role = auth()->user()->role;

        // Common data for all roles
        $totalUsers = User::count();
        $totalIndustrialProposal = IndustrialProposal::count();
        $totalProjects = Project::count();

        $pendingAdmin = Project::where('status', 'pending_admin')->count();
        $rejectAdmin = Project::where('status', 'rejected_admin')->count();

        $research_cells = User::where('role', 'research_cell')->limit(5)->orderBy('created_at')->get();
        $supervisors = User::where('role', 'supervisor')->limit(5)->orderBy('created_at')->get();
        $students = User::where('role', 'student')->limit(10)->orderBy('created_at')->get();


        $pendingProjectsRc = null;
        $rejectProjectsRc = null;
        $pendingProjectsCoSupervisor = null;
        $pendingProjectsSupervisor = null;
        $rejectProjectsSupervisor = null;


        $pendingProjectsRc = Project::where('status', 'pending_research_cell')->count();
        $rejectProjectsRc = Project::where('status', 'rejected_research_cell')->count();



        $supervisorId = Auth::id();

        $pendingProjectsSupervisor = Project::where([['supervisor_id', $supervisorId], ['status', 'pending_supervisor']])->count();
        $rejectProjectsSupervisor = Project::where([['supervisor_id', $supervisorId], ['status', 'rejected_supervisor']])->count();

        $pendingProjectsCoSupervisor = Project::where('cosupervisor_id', $supervisorId)->count();

        $studentId = Auth::id();
        $studentMyProjectsCount = Project::where('created_by', $studentId)->count();

                $rCellCounts = RCell::withCount('projects')->get();


        return view('dashboard', compact(
            'user_role',
            'totalUsers',
            'totalIndustrialProposal',
            'totalProjects',
            'research_cells',
            'supervisors',
            'students',
                        'rCellCounts',


            'studentMyProjectsCount',

            'pendingAdmin',
            'rejectAdmin',

            'pendingProjectsRc',
            'rejectProjectsRc',

            'pendingProjectsSupervisor',
            'rejectProjectsSupervisor',
            'pendingProjectsCoSupervisor'
        ));
    }
}
