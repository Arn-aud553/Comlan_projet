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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'check.admin' => \App\Http\Middleware\CheckAdmin::class,
            'check.client' => \App\Http\Middleware\CheckClient::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        // Redirection des guests (non authentifiés) vers login
        // La redirection des users authentifiés est gérée par le middleware 'guest' personnalisé
        $middleware->redirectTo(
            guests: '/login'
        );

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

