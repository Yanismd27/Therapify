<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                return redirect()->route(match($user->role) {
                    'therapist' => 'therapist.dashboard',
                    'patient' => 'patient.dashboard',
                    'admin' => 'admin.dashboard',
                    default => 'home'
                });
            }
        }

        return $next($request);
    }
}