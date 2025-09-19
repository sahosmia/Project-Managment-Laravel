<?php

namespace App\Http\Controllers;

use App\Http\Requests\RCellRequest;
use App\Models\RCell;
use App\Models\User;
use Illuminate\Http\Request;

class RCellController extends Controller
{

    public function index(Request $request)
    {
        $rCellsQuery = RCell::with('researchCellHead');

        if ($request->has('name') && $request->input('name') !== null) {
            $rCellsQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $r_cells = $rCellsQuery->paginate(10)->withQueryString();
        return view('r-cells.index', compact('r_cells'));
    }

    public function create()
    {
        $faculty_members = User::where('role', 'faculty_member')->get();
        return view('r-cells.create', compact('faculty_members'));
    }

    public function store(RCellRequest $request)
    {
        $validate = $request->validated();
        RCell::create($validate);

        return redirect()->route('r_cells.index')->with('success', 'RCell created successfully.');
    }

    public function show(RCell $r_cell)
    {
        return view('r-cells.show', compact('r_cell'));
    }

    public function edit(RCell $r_cell)
    {
        $faculty_members = User::where('role', 'faculty_member')->get();
        return view('r-cells.edit', compact('r_cell', 'faculty_members'));
    }

    public function update(RCellRequest $request, RCell $r_cell)
    {
        $validate = $request->validated();
        $r_cell->update($validate);

        return redirect()->route('r_cells.index')->with('success', 'RCell updated successfully.');
    }

    public function destroy(RCell $r_cell)
    {
        $r_cell->delete();
        return redirect()->route('r_cells.index')->with('success', 'RCell deleted successfully.');
    }
}
