<?php
// app/Http/Middleware/EmployeeMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role === 'employee') {
            return $next($request);
        }

        return redirect('/home')->with('error', "Access denied.");
    }
}
