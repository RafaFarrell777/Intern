<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $user = Auth::user();
        
        if ($user->role !== $role) {
            if ($user->role === 'mentor') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('landing');
            }
        }

        return $next($request);
    }
} 