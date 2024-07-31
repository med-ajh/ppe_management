<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\CostCenter;
use App\Models\Activity;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('lastname', 'like', '%' . $request->search . '%')
                  ->orWhere('te', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        $users = $query->paginate(10);

        $departments = Department::all();
        $costCenters = CostCenter::all();

        // Example recent activities (replace with actual implementation)
        $recentActivities = Activity::latest()->limit(5)->get();

        return view('admin.dashboard', compact('users', 'departments', 'costCenters', 'recentActivities'));
    }

    /**
     * Store a new activity record.
     *
     * @param string $description
     * @param int $userId
     */
    protected function logActivity($description, $userId)
    {
        Activity::create([
            'description' => $description,
            'user_id' => $userId,
        ]);
    }

    /**
     * An example method where an activity might be logged.
     */
    public function someAction(Request $request)
    {
        // Your action logic here

        // Log activity
        $this->logActivity('User performed some action.', auth()->id());

        // Redirect or return view
    }
}
