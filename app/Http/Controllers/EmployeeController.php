<?php

// app/Http/Controllers/EmployeeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        return view('employee.dashboard', compact('employee'));
    }
}

