<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Authcheck;
use App\Http\Middleware\VolunteerMiddleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register your middleware aliases here
        $middleware->alias([
            'authcheck' => Authcheck::class,
            'volunteer' => VolunteerMiddleware::class,
            'admin' => AdminMiddleware::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom exception handling if needed
    })
    ->create();
