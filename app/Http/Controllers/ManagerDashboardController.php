<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\ValueStream;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        return view('manager.dashboard');
    }

    public function employees()
    {
        $employees = User::where('role', 'employee')
                         ->where('manager_id', auth()->id())
                         ->paginate(10);

        return view('manager.employees.index', compact('employees'));
    }

    public function show($id)
    {
        $employee = User::findOrFail($id);
        return view('manager.employees.show', compact('employee'));
    }

    public function create()
    {
        $departments = Department::all();
        $valueStreams = ValueStream::all();

        return view('manager.employees.create', [
            'departments' => $departments,
            'valueStreams' => $valueStreams
        ]);
    }



     function edit($id)
    {
        $employee = User::findOrFail($id);
        $currentUser = auth()->user();
        $departments = Department::where('manager_id', $currentUser->id)->get();
        $valueStreams = ValueStream::where('manager_id', $currentUser->id)->get(); // Filter based on manager

        return view('manager.employees.edit', compact('employee', 'departments', 'valueStreams'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'te' => 'required|string|max:6',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'value_stream_id' => 'required|exists:value_streams,id',
            'department_id' => 'nullable|exists:departments,id',
            'cost_center' => 'nullable|string|max:255',
        ]);

        $role = $request->input('role', 'employee'); // Default to 'employee' if not provided

        $user = User::create([
            'name' => $validated['name'],
            'lastname' => $validated['lastname'],
            'te' => $validated['te'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $role,
            'value_stream_id' => $validated['value_stream_id'],
            'department_id' => $validated['department_id'],
            'manager_id' => auth()->id(), // Automatically set the manager_id
            'cost_center' => $validated['cost_center'],
        ]);

        return redirect()->route('manager.employees.index')->with('success', 'User created successfully');
    }


    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'te' => 'required|string|max:6|unique:users,te,' . $employee->id,
            'email' => 'required|email|max:255|unique:users,email,' . $employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'value_stream_id' => 'nullable|exists:value_streams,id',
            'department_id' => 'required|exists:departments,id',
            'cost_center' => 'nullable|string|max:255',
        ]);

        $employee->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'te' => $request->te,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $employee->password,
            'role' => $request->role ?? $employee->role, // Preserve existing role if not changed
            'value_stream_id' => $request->value_stream_id,
            'department_id' => $request->department_id,
            'cost_center' => $request->cost_center,
        ]);

        return redirect()->route('manager.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->route('manager.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
