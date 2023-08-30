<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = auth()->user();
    
        if ($user->isAdmin() || in_array('user', $roles)) {
            return $next($request);
        }
    
        return response()->json(['message' => 'You do not have the required role to access this resource.'], 403);
    }

        /*if (!auth()->check()) {
            return redirect('login');
        }
    
        $user = auth()->user();
    
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }
    
        abort(403, 'Unauthorized.');*/
    }

