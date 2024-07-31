<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = CostCenter::all();
        return view('cost_centers.index', compact('costCenters'));
    }

    public function create()
    {
        return view('cost_centers.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        CostCenter::create($request->all());
        return redirect()->route('cost_centers.index')->with('success', 'Cost Center created successfully.');
    }

    public function edit(CostCenter $costCenter)
    {
        return view('cost_centers.edit', compact('costCenter'));
    }

    public function update(Request $request, CostCenter $costCenter)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $costCenter->update($request->all());
        return redirect()->route('cost_centers.index')->with('success', 'Cost Center updated successfully.');
    }

    public function destroy(CostCenter $costCenter)
    {
        $costCenter->delete();
        return redirect()->route('cost_centers.index')->with('success', 'Cost Center deleted successfully.');
    }
}

