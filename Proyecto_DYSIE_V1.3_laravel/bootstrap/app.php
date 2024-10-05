<?php

use App\Http\Middleware\CheckAuthenticated;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user'=> CheckAuthenticated::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
