<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'te' => 'nullable|string|max:50',
            'email' => 'required|string|email|max:50|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|in:employee,manager,admin',
            'departement_id' => 'nullable|integer',
            'cost_center_id' => 'nullable|integer',
            'manager_id' => 'nullable|integer',
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );



        session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);
        Auth::login($user);
        return redirect('/dashboard');
    }
}
