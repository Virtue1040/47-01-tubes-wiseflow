<?php

namespace App\Http\Middleware;

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
        $middleware->redirectUsersTo('/view/home');
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => CustomPermissionMiddleware::class,
            'hasProperty' => \App\Http\Middleware\hasProperty::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'hasRole' => CheckUserRole::class,
            'hasNoRole' => CheckUserNoRole::class,
        ]);
        $middleware->validateCsrfTokens([
            'api/*',
            'login',
            'logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();