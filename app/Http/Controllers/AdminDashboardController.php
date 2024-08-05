<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Departement;
use App\Models\CostCenter;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }


    public function employees()
{
    $employees = User::where('role', 'employee')->get();
    // Adjust this as needed
    return view('admin.employees', compact('employees'));
}

public function users()
{
    $users = User::all(); // Adjust this as needed
    return view('admin.users', compact('users'));
}

public function managers()
{
    $managers = User::where('role', 'manager')->get();
    return view('admin.managers', compact('managers'));
}



}
