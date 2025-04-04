<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // ✅ Check if admin is already logged in via session
        if (session()->has('AdminLogin')) {
            return redirect()->route('dashboard'); // redirect to admin dashboard
        }

        // ✅ Then check default user guard
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME); // redirect to user home
            }
        }

        return $next($request);
    }
}
