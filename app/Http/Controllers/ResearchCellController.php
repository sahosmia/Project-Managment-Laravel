<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ResearchCellController extends Controller
{
   

    public function pendingProjects()
    {
        $projects = Project::where('status', 'pending_research_cell')->with('creator', 'members')->get();
        return view('research_cell.projects.pending', compact('projects'));
    }

    public function approveProject(Project $project)
    {
        $project->update(['status' => 'approved_by_research_cell']);
        return back()->with('success', 'Project approved and sent to Admin.');
    }

    public function rejectProject(Project $project)
    {
        $project->update(['status' => 'rejected_by_research_cell']);
        return back()->with('success', 'Project rejected and sent back to Student.');
    }
}
