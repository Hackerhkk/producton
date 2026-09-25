<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SingleSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        $sessionToken = $request->session()->get('login_token');

        if (
            empty($sessionToken) ||
            empty($user->login_token) ||
            !hash_equals((string) $user->login_token, (string) $sessionToken)
        ) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Your account was logged in from another device.');
        }

        return $next($request);
    }
}