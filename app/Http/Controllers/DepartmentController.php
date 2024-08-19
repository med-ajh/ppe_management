<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ValueStream;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Show the list of departments
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch departments with optional search
        $departments = Department::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('cost_center', 'like', "%{$search}%");
        })->with('valueStream')->get();

        return view('departments.index', [
            'departments' => $departments,
        ]);
    }

    // Show the form for creating a new department
    public function create()
    {
        $valueStreams = ValueStream::all();
        return view('departments.create', [
            'valueStreams' => $valueStreams,
        ]);
    }

    // Store a newly created department in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost_center' => 'required|string|max:255',
            'value_stream_id' => 'required|exists:value_streams,id',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    // Show the form for editing the specified department
    public function edit(Department $department)
    {
        $valueStreams = ValueStream::all();
        return view('departments.edit', [
            'department' => $department,
            'valueStreams' => $valueStreams,
        ]);
    }

    // Update the specified department in storage
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost_center' => 'required|string|max:255',
            'value_stream_id' => 'required|exists:value_streams,id',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    // Remove the specified department from storage
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
