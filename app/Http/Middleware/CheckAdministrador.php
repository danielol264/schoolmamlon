<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckAdministrador
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->ROL === 'G') {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado. Solo administradores.');
    }
}
