<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        return view('manager.dashboard');
    }
}
