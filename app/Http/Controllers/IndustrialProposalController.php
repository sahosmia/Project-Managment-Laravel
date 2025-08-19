<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IndustrialProposal;
use App\Models\User;
use Illuminate\Http\Request;

class IndustrialProposalController extends Controller
{
    public function index()
    {
        $proposals = IndustrialProposal::with(['user', 'company', 'supervisor'])->get();
        return view('industrial-proposals.index', compact('proposals'));
    }


    public function create()
    {
        $user = auth()->user();
        $companies = Company::all();
        $supervisors = User::where('role', 'supervisor')->get();
        return view('industrial-proposals.create', compact('user', 'companies', 'supervisors'));
    }

    public function store(Request $request)
    {
        $existingProposal = IndustrialProposal::where('user_id', auth()->id())->first();
        if ($existingProposal) {
            return redirect()->back()->with('error', 'You have already submitted an industrial proposal.');
        }

        $request->validate([
            'skills' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'supervisor_id' => 'required|exists:users,id',
        ]);

        IndustrialProposal::create([
            'user_id' => auth()->id(),
            'skills' => $request->skills,
            'company_id' => $request->company_id,
            'supervisor_id' => $request->supervisor_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Industrial proposal submitted successfully.');
    }
}
