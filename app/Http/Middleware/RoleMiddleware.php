<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
{
    // 1. Check if user is logged in
    if (! $request->user()) {
        return redirect('/login');
    }

    // 2. Check if the user's role matches the required role
    if ($request->user()->role !== $role) {
        $userRole = $request->user()->role;
        
        // Redirect to the appropriate dashboard if they hit the wrong endpoint
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($userRole === 'department') {
            return redirect()->route('department.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }

    return $next($request);
}
}
