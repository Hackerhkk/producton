<?php

use App\Http\Middleware\SingleSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Middleware Aliases
        |--------------------------------------------------------------------------
        */
$middleware->trustProxies(at: '*');
        $middleware->alias([
            'admin' => \App\Http\Middleware\Adminauth::class,
            'active' => \App\Http\Middleware\CheckUserActive::class,
            'test.access' => \App\Http\Middleware\CheckTestAccess::class,
            'single.session' => SingleSession::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Web Middleware
        |--------------------------------------------------------------------------
        */

        $middleware->web(append: [
            \App\Http\Middleware\AutomaticFeeProcessing::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
