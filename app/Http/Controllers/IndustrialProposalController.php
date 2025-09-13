<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IndustrialProposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndustrialProposalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = IndustrialProposal::with(['user', 'company', 'supervisor']);
        if($user->role == 'supervisor'){
            $query->where('supervisor_id', $user->id);
        }
        $proposals = $query->paginate(10)->withQueryString();
        return view('industrial-proposals.index', compact('proposals'));
    }


    public function create()
    {
        $industrialProposal = IndustrialProposal::where('user_id', auth()->id())->first();
        $user = auth()->user();
        $companies = Company::all();
        $supervisors = User::where('role', 'supervisor')->get();
        return view('industrial-proposals.create', compact('user', 'companies', 'supervisors', 'industrialProposal'));
    }

 public function store(Request $request)
{
    $validatedData = $request->validate([
        'skills' => 'required|string',
        'manage_own_internship' => 'required|in:yes,no',
        'company_id' => 'required_if:manage_own_internship,yes|nullable|exists:companies,id',
        'supervisor_id' => 'required|exists:users,id',
    ]);

    if ($validatedData['manage_own_internship'] === 'yes') {
        $total_company_interested = IndustrialProposal::where('company_id', $validatedData['company_id'])
            ->where('status', 'pending')
            ->count();

        $company = Company::findOrFail($validatedData['company_id']);

        if ($company->quantity <= $total_company_interested) {
            return redirect()->back()->with('error', 'Company has no available seat.');
        }
    }

    $existingProposal = IndustrialProposal::where('user_id', auth()->id())->first();

    if ($existingProposal) {

        if ($existingProposal->status === 'pending') {
            $existingProposal->update([
                'skills' => $validatedData['skills'],
                'company_id' => $validatedData['company_id'],
                'supervisor_id' => $validatedData['supervisor_id'],
            ]);

            return redirect()->route('dashboard')->with('success', 'Industrial proposal updated successfully.');
        } else {
            return redirect()->back()->with('error', 'You have already submitted an industrial proposal which is not pending.');
        }
    } else {
        IndustrialProposal::create([
            'user_id' => auth()->id(),
            'skills' => $validatedData['skills'],
            'company_id' => $validatedData['company_id'],
            'supervisor_id' => $validatedData['supervisor_id'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Industrial proposal submitted successfully.');
    }
}



    public function edit(IndustrialProposal $industrial_proposal)
    {
        $companies = Company::all();
        $supervisors = User::where('role', 'supervisor')->get();
        return view('industrial-proposals.edit', compact('industrial_proposal', 'companies', 'supervisors'));
    }

    public function update(Request $request, IndustrialProposal $industrial_proposal)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'supervisor_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,inprogress,complete',
        ]);

        $company = Company::find($request->company_id);
        $assigned_count = IndustrialProposal::where('company_id', $company->id)->count();

        if ($assigned_count >= $company->quantity) {
            return redirect()->back()->with('error', 'The selected company has reached its maximum capacity for interns.');
        }

        $industrial_proposal->update([
            'company_id' => $request->company_id,
            'supervisor_id' => $request->supervisor_id,
            'status' => $request->status,
        ]);

        return redirect()->route('industrial-proposals.index')->with('success', 'Industrial proposal updated successfully.');
    }
}
