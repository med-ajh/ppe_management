<?php

// app/Http/Controllers/ManagerController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        $manager = Auth::user();
        $employees = $manager->employees()->get();
        return view('manager.dashboard', compact('employees'));
    }
}

