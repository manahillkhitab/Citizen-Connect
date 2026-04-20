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
    // Example: If route requires 'admin' but user is 'citizen', deny access.
    if ($request->user()->role !== $role) {
        abort(403, 'Unauthorized action. You do not have permission.');
    }

    return $next($request);
}
}
