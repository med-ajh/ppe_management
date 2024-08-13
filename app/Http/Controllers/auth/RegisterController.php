<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\ValueStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $departments = Department::all();
        $valueStreams = ValueStream::all();
        $managers = User::where('role', 'manager')->get();
        return view('session.register', compact('departments', 'valueStreams', 'managers'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

     public function register(Request $request)
     {
         // Format TE ID
         $te = $request->input('te');
         if (!preg_match('/^TE\d{6}$/', $te)) {
             return redirect()->back()->withErrors(['te' => 'TE ID must start with TE followed by exactly 6 digits.']);
         }

         // Append @te.com if not present
         $email = $request->input('email');
         if (!str_contains($email, '@te.com')) {
             $email .= '@te.com';
         }

         $request->merge(['email' => $email]);

         $request->validate([
             'name' => 'required|string|max:25',
             'lastname' => 'required|string|max:25',
             'te' => 'required|string|max:8|unique:users,te',
             'email' => 'required|string|email|max:50|unique:users,email',
             'password' => 'required|string|confirmed|min:8',
             'role' => 'required|in:employee,manager,admin',
             'value_stream_id' => 'required|integer|exists:value_streams,id',
             'department_id' => 'required|integer|exists:departments,id',
             'manager_id' => 'nullable|integer|exists:users,id',
             'cost_center' => 'nullable|string',
         ]);

         $userData = $request->only([
             'name',
             'lastname',
             'te',
             'email',
             'role',
             'value_stream_id',
             'department_id',
             'manager_id',
             'cost_center'
         ]);
         $userData['password'] = Hash::make($request->password);

         $user = User::create($userData);

         Auth::login($user);

         // Redirect based on the user's role
         switch ($user->role) {
             case 'admin':
                 return redirect()->route('admin.dashboard');
             case 'manager':
                 return redirect()->route('manager.dashboard');
             default:
                 return redirect()->route('employee.dashboard');
         }
     }



}
