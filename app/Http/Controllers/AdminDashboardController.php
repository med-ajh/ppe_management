<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\ValueStream;
use Illuminate\Support\Facades\Hash;

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
        $departments = Department::all();
        $valueStreams = ValueStream::all();
        $managers = User::where('role', 'manager')->get();

        return view('admin.users.edit', compact('user', 'departments', 'valueStreams', 'managers'));
    }

    public function updateUser (Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'te' => 'required|string|max:12|unique:users,te,' . $user->id,
            'email' => 'required|string|email|max:50|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:8',
            'role' => 'required|in:employee,manager,admin',
            'value_stream_id' => 'nullable|integer',
            'department_id' => 'required|integer',
            'cost_center_id' => 'nullable|integer',
            'manager_id' => 'nullable|integer',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }



    public function createUser()
    {
        $departments = Department::all();
        $valueStreams = ValueStream::all();
        $managers = User::where('role', 'manager')->get();

        return view('admin.users.create', compact('departments', 'valueStreams', 'managers'));
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'te' => 'required|string|max:255|unique:users,te',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:employee,manager,admin',
            'value_stream_id' => 'required_if:role,employee|exists:value_streams,id',
            'department_id' => 'required_if:role,employee|exists:departments,id',
            'manager_id' => 'nullable|exists:users,id',
            'cost_center' => 'nullable|string|max:255',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->te = $request->input('te');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->value_stream_id = $request->input('value_stream_id');
        $user->department_id = $request->input('department_id');
        $user->manager_id = $request->input('manager_id');
        $user->cost_center = $request->input('cost_center');
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User added successfully!');
    }
}


