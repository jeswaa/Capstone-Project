<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('staff')->check() && Auth::guard('staff')->user()->role === 'staff') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Staff only.');
    }
}