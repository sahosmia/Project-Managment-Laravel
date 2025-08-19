<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
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
    $totalProjects = Project::count();

    $globalPendingProjects = Project::where('status', 'approved_by_research_cell')->count();

    $research_cells = User::where('role', 'research_cell')->limit(5)->orderBy('created_at')->get();
    $supervisors = User::where('role', 'supervisor')->limit(5)->orderBy('created_at')->get();
    $students = User::where('role', 'student')->limit(10)->orderBy('created_at')->get();

    // Initialize role-specific data to null
    $pendingProjectsCount = null;
    $approvedProjectsCount = null;
    $rejectedProjectsCount = null;
    $supervisorMyProjectsCount = null;
    $studentMyProjectsCount = null;

    if ($user_role == "admin") {
        $pendingProjectsCount = Project::where('status', 'pending_research_cell')->count();
        $approvedProjectsCount = Project::where('status', 'approved_by_research_cell')->count();
        $rejectedProjectsCount = Project::where('status', 'rejected_research_cell')->count();
    } elseif ($user_role == "research_cell") {

 $pendingProjectsCount = Project::where('status', 'pending_research_cell')->count();
        $approvedProjectsCount = Project::where('status', 'approved_by_research_cell')->count();
        $rejectedProjectsCount = Project::where('status', 'rejected_research_cell')->count();

    } elseif ($user_role == "supervisor") {
        $supervisorId = Auth::id();
        $supervisorMyProjectsCount = Project::where('supervisor_id', $supervisorId)->count();

    } elseif ($user_role == "student") {
        $studentId = Auth::id();
        $studentMyProjectsCount = Project::where('created_by', $studentId)->count();
    }

    return view('dashboard', compact(
        'user_role',
        'totalUsers',
        'totalProjects',
        'globalPendingProjects',
        'research_cells',
        'supervisors',
        'students',
        'pendingProjectsCount',
        'approvedProjectsCount',
        'rejectedProjectsCount',
        'supervisorMyProjectsCount',
        'studentMyProjectsCount',
    ));
    }


}
