<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAdministrador as RolAdmin;
use App\Http\Middleware\CheckMaestro as RolMaestro;
use App\Http\Middleware\CheckAlumno as RolAlumno;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'rol.admin' => RolAdmin::class,
            'rol.maestro' => RolMaestro::class,
            'rol.alumno' => RolAlumno::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
