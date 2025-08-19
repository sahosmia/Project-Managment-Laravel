<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{

      public function index(Request $request)
    {
        $companiesQuery = Company::query();

        if ($request->has('name') && $request->input('name') !== null) {
            $companiesQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $companies = $companiesQuery->paginate(10)->withQueryString();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
       $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
        ]);

        Company::create($validate);


        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
       $validate = $request->validate([
            'description' => 'nullable|string',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $company->update($validate);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
