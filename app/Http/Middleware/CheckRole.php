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
        // Debug logging
        Log::info('Role check', [
            'user_id' => $request->user()?->id,
            'user_role' => $request->user()?->role,
            'required_roles' => $role
        ]);

        // Si pas d'utilisateur connecté
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Si admin, autoriser tout
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        // Convertir en tableau si c'est une chaîne
        $roles = explode('|', $role);

        // Vérifier si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Log si non autorisé
        Log::warning('Unauthorized access attempt', [
            'user_id' => $request->user()->id,
            'user_role' => $request->user()->role,
            'required_roles' => $roles
        ]);

        return redirect()->route('unauthorized');
    }
}