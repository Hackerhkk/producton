<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Adminauth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['admin'=>'App\Http\Middleware\Adminauth']);
        $middleware->web(append: [
    \App\Http\Middleware\AutomaticFeeProcessing::class,
]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
