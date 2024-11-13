<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
    
        Log::info('Role check', [
            'user_id' => $request->user()?->id,
            'user_role' => $request->user()?->role,
            'required_roles' => $role
        ]);

      
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        
        $roles = explode('|', $role);

        
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

     
        Log::warning('Unauthorized access attempt', [
            'user_id' => $request->user()->id,
            'user_role' => $request->user()->role,
            'required_roles' => $roles
        ]);

        return redirect()->route('unauthorized');
    }
}