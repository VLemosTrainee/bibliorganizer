<?php

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
                'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
                // ... (outros aliases)
                'admin' => \App\Http\Middleware\AdminMiddleware::class, // Adicione esta linha
            ]);
        })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();