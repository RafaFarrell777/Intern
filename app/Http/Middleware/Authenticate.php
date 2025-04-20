<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('auth.login');
        }
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        $user = Auth::user();
        
        // Check if the user is trying to access admin routes
        if ($request->is('/') || 
            $request->is('application*') || 
            $request->is('users*') || 
            $request->is('internship-programs*')) {
            if ($user->role !== 'mentor') {
                return redirect()->route('landing');
            }
        }
        
        // Check if the user is trying to access intern routes
        if ($request->is('landing')) {
            if ($user->role !== 'magang') {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
} 