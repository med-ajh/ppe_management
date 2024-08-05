<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departement;
use App\Models\CostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $departements = Departement::all();
        $costCenters = CostCenter::all();
        $managers = User::where('role', 'manager')->get();
        return view('session.register', compact('departements', 'costCenters', 'managers'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'te' => 'required|string|max:12|unique:users,te',
            'email' => 'required|string|email|max:50|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:employee,manager,admin',
            'departement_id' => 'required|integer',
            'cost_center_id' => 'nullable|integer',
            'manager_id' => 'nullable|integer',
        ]);

        $userData = $request->only(['name', 'lastname', 'te', 'email', 'role', 'departement_id', 'cost_center_id', 'manager_id']);
        $userData['password'] = Hash::make($request->password);

        $user = User::create($userData);

        Auth::login($user);

        // Redirect based on the user's role
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'manager') {
            return redirect()->route('manager.dashboard');
        } else {
            return redirect()->route('employee.dashboard');
        }
    }




}
