<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    //...$roles
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Controleren of de gebruiker is ingelogd
        if (! Auth::check()){
            abort(403, 'U heeft geen toegang tot deze pagina.');
        }

        $user = Auth::user();

        // Controleren of de gebruiker een van de vereiste rollen heeft
        if (!$user->roles()->whereIn('name', $roles)->exists()) {
            // De gebruiker heeft niet de vereiste rol
            abort(403, 'U heeft geen toegang tot deze pagina.');
        }

        return $next($request);
    }
}
