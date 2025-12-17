<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    */
    ->withMiddleware(function (Middleware $middleware) {

        /*
        |--------------------------------------------------------------
        | Web Middleware Stack (standard Laravel behavior)
        |--------------------------------------------------------------
        */
        $middleware->web(append: [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            VerifyCsrfToken::class,
        ]);

        /*
        |--------------------------------------------------------------
        | Middleware Aliases
        |--------------------------------------------------------------
        */
        $middleware->alias([
            'auth'  => Authenticate::class,
            'csrf'  => VerifyCsrfToken::class,
            'role'  => RoleMiddleware::class, // ✅ THIS FIXES YOUR ERROR
        ]);
    })

    /*
    |--------------------------------------------------------------------------
    | Exceptions
    |--------------------------------------------------------------------------
    */
    ->withExceptions(function (Exceptions $exceptions) {
        // Default Laravel exception handling
    })

    ->create();
