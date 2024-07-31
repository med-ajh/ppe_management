<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use App\Models\Department; // Import the Department model
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = CostCenter::with('department')->get();
        return view('cost_centers.index', compact('costCenters'));
    }

    public function create()
    {
        $departments = Department::all(); // Fetch all departments
        return view('cost_centers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id', // Validate department_id
        ]);

        CostCenter::create($request->all());

        return redirect()->route('cost_centers.index')->with('success', 'Cost Center created successfully.');
    }

    public function edit(CostCenter $costCenter)
    {
        $departments = Department::all(); // Fetch all departments
        return view('cost_centers.edit', compact('costCenter', 'departments'));
    }

    public function update(Request $request, CostCenter $costCenter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id', // Validate department_id
        ]);

        $costCenter->update($request->all());

        return redirect()->route('cost_centers.index')->with('success', 'Cost Center updated successfully.');
    }

    public function destroy(CostCenter $costCenter)
    {
        $costCenter->delete();
        return redirect()->route('cost_centers.index')->with('success', 'Cost Center deleted successfully.');
    }
}
