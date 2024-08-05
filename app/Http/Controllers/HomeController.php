<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Redirect based on the user's role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'employee':
                return redirect()->route('employee.dashboard');
            default:
                return redirect('/'); // Default fallback route
        }
    }
}
