<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\DashboardAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias(['isAdmin'=>DashboardAccess::class,
        
    ]);
    $middleware->validateCsrfTokens(except: [
        '/blog/like' // <-- exclude this route
    ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
