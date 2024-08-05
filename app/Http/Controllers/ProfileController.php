<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the profile of the currently authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user()->load(['departement', 'costCenter', 'manager']);

        return view('profile', [
            'user' => $user
        ]);
    }
}
