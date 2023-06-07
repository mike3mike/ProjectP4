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
        // if (! Auth::check() || $request->user()->role != $role) 
        if (! Auth::check() || ! in_array($request->user()->role, $roles)){
            // De gebruiker is niet ingelogd of heeft niet de juiste rol.
            // Je kunt hier ook een redirect naar een andere pagina uitvoeren als je dat wilt.
            abort(403, 'U heeft geen toegang tot deze pagina.');
        
        }


        return $next($request);
    }

}

