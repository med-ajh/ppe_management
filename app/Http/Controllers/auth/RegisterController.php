<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|string|in:admin,manager,employee',
            'departement_id' => 'nullable|integer',
            'cost_center_id' => 'nullable|integer',
            'manager_id' => 'nullable|integer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'departement_id' => $request->departement_id,
            'cost_center_id' => $request->cost_center_id,
            'manager_id' => $request->manager_id,
        ]);

        auth()->login($user);

        return redirect($this->redirectPath());
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
