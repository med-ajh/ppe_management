<?php

// app/Http/Middleware/ManagerMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role === 'manager') {
            return $next($request);
        }

        return redirect('/home')->with('error', "Access denied.");
    }
}

