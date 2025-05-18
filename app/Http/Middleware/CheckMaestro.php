<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaestro
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   // app/Http/Middleware/CheckMaestro.php
    public function handle(Request $request, Closure $next)
    {
    if (auth::check() && auth::user()->rol === 'M') {
        return $next($request);
    }
    abort(403, 'Acceso no autorizado');
    }
}
