<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departement; // Import the Departement model if needed

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
                         ->get();

        return view('manager.employees.index', compact('employees'));
    }

    public function show($id)
    {
        $employee = User::findOrFail($id);
        return view('manager.employees.show', compact('employee'));
    }

    public function create()
    {
        $departements = Departement::all(); // Fetch departments if needed
        return view('manager.employees.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'te' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:employee',
            'departement_id' => 'nullable|exists:departements,id',
        ]);

        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'te' => $request->te,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'departement_id' => $request->departement_id,
            'manager_id' => auth()->id(), // Set the current manager as the creator
        ]);

        return redirect()->route('manager.employees.index')->with('success', 'Employee created successfully.');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->route('manager.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
