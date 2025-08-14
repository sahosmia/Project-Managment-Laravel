<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\RCell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RCellController extends Controller
{

    public function index(Request $request)
    {
        $rCellsQuery = RCell::query();

        if ($request->has('name') && $request->input('name') !== null) {
            $rCellsQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('role') && $request->input('role') !== null && $request->input('role') !== '') {
            $validRoles = ['admin', 'student', 'supervisor', 'research_cell'];
            if (in_array($request->input('role'), $validRoles)) {
                $rCellsQuery->where('role', $request->input('role'));
            }
        }

        $r_cells = $rCellsQuery->paginate(10)->withQueryString();
        return view('r-cells.index', compact('r_cells'));
    }

    public function create()
    {
        return view('r-cells.create');
    }

    public function store(Request $request)
    {
       $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        RCell::create($validate);


        return redirect()->route('r_cells.index')->with('success', 'RCell created successfully.');
    }

    public function show(RCell $r_cell)
    {
        return view('r-cells.show', compact('r_cell'));
    }

    public function edit(RCell $r_cell)
    {
        return view('r-cells.edit', compact('r_cell'));
    }

    public function update(Request $request, RCell $r_cell)
    {
       $validate = $request->validate([
            'description' => 'nullable|string',
            'name' => 'required|string|max:255',

        ]);

        $r_cell->update($validate);

        return redirect()->route('r_cells.index')->with('success', 'RCell updated successfully.');
    }

    public function destroy(RCell $r_cell)
    {
        $r_cell->delete();
        return redirect()->route('r_cells.index')->with('success', 'RCell deleted successfully.');
    }




}
