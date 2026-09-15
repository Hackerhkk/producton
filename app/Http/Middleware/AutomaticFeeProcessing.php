<?php

namespace App\Http\Middleware;

use App\Services\FeeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutomaticFeeProcessing
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Only process for logged-in users
        |--------------------------------------------------------------------------
        */

        if (auth()->check()) {

            try {

                app(FeeService::class)
                    ->autoProcessDueFees();

            } catch (\Throwable $e) {

                /*
                |--------------------------------------------------------------------------
                | Fee processing failure should NEVER break the website
                |--------------------------------------------------------------------------
                */

                report($e);
            }
        }

        return $next($request);
    }
}