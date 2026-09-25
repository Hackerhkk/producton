<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Authenticate email + password
        |--------------------------------------------------------------------------
        */
        $request->authenticate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Check account status
        |--------------------------------------------------------------------------
        */
        if ($user && !$user->is_active) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' =>
                        'Your account has been disabled. Please contact the administrator.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2FA CHECK
        |--------------------------------------------------------------------------
        |
        | If 2FA is enabled, don't create the final login session yet.
        | Store only the user ID temporarily and send the user to OTP page.
        |
        */
        if (
            $user &&
            $user->two_factor_enabled &&
            !empty($user->two_factor_secret)
        ) {
            /*
             * Regenerate session ID for security.
             */
            $request->session()->regenerate();

            /*
             * Store temporary 2FA authentication state.
             */
            $request->session()->put(
                'two_factor_pending_user_id',
                $user->id
            );

            /*
             * Logout the normal Laravel authentication session.
             *
             * User is NOT considered fully logged in until OTP succeeds.
             */
            Auth::guard('web')->logout();

            return redirect()->route('two-factor.challenge');
        }

        /*
        |--------------------------------------------------------------------------
        | NORMAL LOGIN - 2FA NOT ENABLED
        |--------------------------------------------------------------------------
        */
        $request->session()->regenerate();

        $loginToken = Str::random(64);

        $user->update([
            'login_token' => $loginToken,
        ]);

        $request->session()->put(
            'login_token',
            $loginToken
        );

        return redirect()->intended(
            route('dashboard', absolute: false)
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->forget([
            'two_factor_pending_user_id',
        ]);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
