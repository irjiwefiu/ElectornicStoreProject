<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // User must be logged in
        if (! Auth::check()) {
            abort(403);
        }

        // Role check
        if (Auth::user()->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
