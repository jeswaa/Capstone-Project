<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class IsAdmin
{
    public function handle(Request $request, Closure $next) {
        logger('=== Middleware Triggered ===');
        logger('Session ID: ' . session()->getId());
        logger('AdminLogin Session: ' . session('AdminLogin'));
        logger('Requested URL: ' . $request->fullUrl());
    
        if (session()->has('AdminLogin')) {
            $admin = Admin::find(session('AdminLogin'));
            if ($admin && $admin->role === 'admin') {
                logger('Admin validated. Proceeding to: ' . $request->path());
                return $next($request);
            }
        }
    
        logger('=== ACCESS DENIED ===');
        abort(403, 'Admins only.');
    }
}
