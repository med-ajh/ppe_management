<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class ManagerDashboardController extends Controller
{
    public function index()
    {
        return view('manager.dashboard');
    }

    public function employees()
    {
        // Corrected the syntax of where method
        $employees = User::where('role', 'employee')
                         ->where('manager_id', auth()->id())
                         ->get();

        return view('manager.employees', compact('employees'));
    }
}
