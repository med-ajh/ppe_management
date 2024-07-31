<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use App\Models\Department;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('department', 'costCenter')->get();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::all();
        $costCenters = CostCenter::all();
        return view('admin.users.create', compact('departments', 'costCenters'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'cost_center_id' => 'nullable|exists:cost_centers,id',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'department_id' => $request->input('department_id'),
            'cost_center_id' => $request->input('cost_center_id'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $departments = Department::all();
        $costCenters = CostCenter::all();
        return view('admin.users.edit', compact('user', 'departments', 'costCenters'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'cost_center_id' => 'nullable|exists:cost_centers,id',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
            'role' => $request->input('role'),
            'department_id' => $request->input('department_id'),
            'cost_center_id' => $request->input('cost_center_id'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }

    /**
     * Get cost centers for a given department.
     *
     * @param  int  $departmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCostCenters($departmentId)
    {
        $costCenters = CostCenter::where('department_id', $departmentId)->get();
        return response()->json($costCenters);
    }
}
