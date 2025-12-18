<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\checkislogin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
        'checkislogin' => \App\Http\Middleware\checkislogin::class,
        'checkrole'    => \App\Http\Middleware\CheckRole::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
