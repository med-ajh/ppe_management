<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    protected function redirectPath()
    {
        if (auth()->user()->isAdmin()) {
            return route('admin.dashboard');
        } elseif (auth()->user()->isManager()) {
            return route('manager.dashboard');
        } else {
            return route('employee.dashboard');
        }
    }
}
