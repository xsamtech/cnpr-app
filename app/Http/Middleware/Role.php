<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;

class Role extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // I included this check because you have it, but it really 
        // should be part of your 'auth' middleware, most likely added as part of a route group.
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->isAdmin())
            return $next($request);

        foreach ($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if ($user->hasRole($role))
                return $next($request);
        }

        return redirect('login');
    }
}
