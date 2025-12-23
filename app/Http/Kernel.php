<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [];

    protected $middlewareGroups = [
        'web' => [],
        'api' => [],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}
