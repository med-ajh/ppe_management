<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use App\Models\Department;
use App\Models\CostCenter;



class ManagerController extends Controller
{
    /**
     * Display the list of employees managed by the current manager.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $managerId = auth()->id();

        $query = User::where('manager_id', $managerId);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        if ($request->has('cost_center_id')) {
            $query->where('cost_center_id', $request->cost_center_id);
        }

        $employees = $query->paginate(10);
        $departments = Department::all();
        $costCenters = CostCenter::all();
        $recentActivities = Activity::whereIn('user_id', $employees->pluck('id'))->latest()->limit(5)->get();


        return view('manager.dashboard', compact('employees', 'departments', 'costCenters', 'recentActivities'));
    }

    /**
     * Show the form to add a new employee.
     *
     * @return \Illuminate\View\View
     */


    /**
     * Store a newly created employee in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


     public function create()
    {
        return view('manager.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'te' => 'nullable|string',
        ]);

        $manager = auth()->user();

        // Get the manager's department and cost center
        $departmentId = $manager->department_id;
        $costCenterId = $manager->cost_center_id;

        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'te' => $request->te,
            'role' => 'employee',
            'department_id' => $departmentId,
            'cost_center_id' => $costCenterId,
            'manager_id' => $manager->id,
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Employee added successfully.');
    }



    public function update(Request $request, User $employee)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $employee->id,
        'password' => 'nullable|confirmed|min:8',
        'te' => 'nullable|string',
    ]);

    $employee->name = $request->name;
    $employee->lastname = $request->lastname;
    $employee->email = $request->email;
    $employee->te = $request->te;

    if ($request->password) {
        $employee->password = bcrypt($request->password);
    }

    // Hidden fields are not updated as they are not included in the update logic

    $employee->save();

    return redirect()->route('manager.dashboard')->with('success', 'Employee updated successfully.');
}

public function edit($id)
{
    $employee = User::findOrFail($id);
    $departments = Department::all();
    $costCenters = CostCenter::all();

    return view('manager.edit', compact('employee', 'departments', 'costCenters'));
}




public function destroy(User $employee)
{
    $employee->delete();
    return redirect()->route('manager.dashboard')->with('success', 'Employee deleted successfully.');
}


public function show(User $employee)
{
    return view('manager.show', compact('employee'));
}

    /**
     * Display the activities of the employees managed by the current manager.
     *
     * @return \Illuminate\View\View
     */
    public function activities()
    {
        $managerId = auth()->id();

        $employees = User::where('manager_id', $managerId)->pluck('id');
        $activities = Activity::whereIn('user_id', $employees)->latest()->paginate(10);

        return view('manager.activities', compact('activities'));
    }
}
