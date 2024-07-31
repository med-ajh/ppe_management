<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Determine where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Determine the redirect path based on user role
        if (auth()->user()->role == 'admin') {
            return route('admin.dashboard');
        } elseif (auth()->user()->role == 'manager') {
            return route('manager.dashboard');
        } elseif (auth()->user()->role == 'employee') {
            return route('employee.dashboard');
        }

        // Fallback
        return '/home';
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // If redirectTo method is not used, this can handle redirection
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($user->role == 'employee') {
            return redirect()->route('employee.dashboard');
        }

        return redirect('/home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
