<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\CostCenter;
class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function employees()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('te', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function managers()
    {
        $managers = User::where('role', 'manager')->get();
        return view('admin.managers.index', compact('managers'));
    }

    public function editUser(User $user)
    {
        $departements = Departement::all();
        $costCenters = CostCenter::all();
        $managers = User::where('role', 'manager')->get();

        return view('admin.users.edit', compact('user', 'departements', 'costCenters', 'managers'));
    }
    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'te' => 'required|string|max:12|unique:users,te',
            'email' => 'required|string|email|max:50|unique:users,email' . $user->id,
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:employee,manager,admin',
            'departement_id' => 'required|integer',
            'cost_center_id' => 'nullable|integer',
            'manager_id' => 'nullable|integer',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}

public function show(User $user)
{
    $user = User::with('departement', 'costCenter', 'manager')->findOrFail($user->id);
    return view('admin.users.show', compact('user'));
}

}
