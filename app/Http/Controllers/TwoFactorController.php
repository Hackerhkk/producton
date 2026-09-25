<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 2FA Challenge
    |--------------------------------------------------------------------------
    */

    public function challenge(Request $request): View|RedirectResponse
    {
        $userId = $request->session()->get(
            'two_factor_pending_user_id'
        );

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget(
                'two_factor_pending_user_id'
            );

            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Google Authenticator Code
    |--------------------------------------------------------------------------
    */

public function verify(Request $request): RedirectResponse
{
    $request->validate([
        'code' => [
            'required',
            'digits:6',
        ],
    ]);

    $userId = $request->session()->get(
        'two_factor_pending_user_id'
    );

    if (!$userId) {
        return redirect()
            ->route('login')
            ->withErrors([
                'email' =>
                    'Your login session has expired. Please login again.',
            ]);
    }

    /*
     * Rate limit key:
     * Pending user + IP
     *
     * This prevents repeated OTP guessing.
     */
    $rateLimitKey = 'two_factor_verify|'
        . $userId
        . '|'
        . $request->ip();

    /*
     * Maximum 5 OTP attempts per minute.
     */
    if (
        \Illuminate\Support\Facades\RateLimiter::tooManyAttempts(
            $rateLimitKey,
            5
        )
    ) {
        $seconds =
            \Illuminate\Support\Facades\RateLimiter::availableIn(
                $rateLimitKey
            );

        return back()
            ->withInput()
            ->withErrors([
                'code' =>
                    'Too many verification attempts. Please try again in '
                    . $seconds
                    . ' seconds.',
            ]);
    }

    $user = User::find($userId);

    if (!$user) {
        $request->session()->forget(
            'two_factor_pending_user_id'
        );

        return redirect()->route('login');
    }

    if (!$user->is_active) {
        $request->session()->forget(
            'two_factor_pending_user_id'
        );

        return redirect()
            ->route('login')
            ->withErrors([
                'email' =>
                    'Your account has been disabled. Please contact the administrator.',
            ]);
    }

    if (
        !$user->two_factor_enabled ||
        empty($user->two_factor_secret)
    ) {
        $request->session()->forget(
            'two_factor_pending_user_id'
        );

        return redirect()
            ->route('login')
            ->withErrors([
                'email' =>
                    'Two-factor authentication is not configured correctly.',
            ]);
    }

    $google2fa = new Google2FA();

    $valid = $google2fa->verifyKey(
        $user->two_factor_secret,
        $request->code
    );

    /*
     * Wrong OTP = consume one attempt.
     */
    if (!$valid) {

        \Illuminate\Support\Facades\RateLimiter::hit(
            $rateLimitKey,
            60
        );

        return back()
            ->withInput()
            ->withErrors([
                'code' =>
                    'The verification code is invalid or has expired.',
            ]);
    }

    /*
     * Correct OTP = clear the rate limit.
     */
    \Illuminate\Support\Facades\RateLimiter::clear(
        $rateLimitKey
    );

    return $this->completeLogin(
        $request,
        $user
    );
}



    /*
    |--------------------------------------------------------------------------
    | Recovery Code Page
    |--------------------------------------------------------------------------
    */

    public function recoveryChallenge(
        Request $request
    ): View|RedirectResponse {

        $userId = $request->session()->get(
            'two_factor_pending_user_id'
        );

        if (!$userId) {
            return redirect()->route('login');
        }

        return view(
            'auth.two-factor-recovery-challenge'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Recovery Code
    |--------------------------------------------------------------------------
    */

    public function verifyRecoveryCode(
        Request $request
    ): RedirectResponse {

        $request->validate([
            'recovery_code' => [
                'required',
                'string',
                'min:8',
                'max:30',
            ],
        ]);

        $userId = $request->session()->get(
            'two_factor_pending_user_id'
        );

        if (!$userId) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Your login session has expired. Please login again.',
                ]);
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget(
                'two_factor_pending_user_id'
            );

            return redirect()->route('login');
        }

        if (!$user->is_active) {
            $request->session()->forget(
                'two_factor_pending_user_id'
            );

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Your account has been disabled. Please contact the administrator.',
                ]);
        }

        $storedCodes = json_decode(
            $user->two_factor_recovery_codes ?? '[]',
            true
        );

        if (!is_array($storedCodes)) {
            $storedCodes = [];
        }

        $enteredCode = strtoupper(
            trim(
                $request->recovery_code
            )
        );

        $matchedIndex = null;

        foreach (
            $storedCodes as $index => $storedCode
        ) {

            /*
             * New secure format:
             * hashed recovery codes
             */
            if (
                is_string($storedCode) &&
                Hash::check(
                    $enteredCode,
                    $storedCode
                )
            ) {
                $matchedIndex = $index;
                break;
            }

            /*
             * Backward compatibility:
             * If old plaintext codes exist,
             * allow them once and immediately remove them.
             */
            if (
                is_string($storedCode) &&
                hash_equals(
                    strtoupper($storedCode),
                    $enteredCode
                )
            ) {
                $matchedIndex = $index;
                break;
            }
        }

        if ($matchedIndex === null) {
            return back()
                ->withInput()
                ->withErrors([
                    'recovery_code' =>
                        'The recovery code is invalid or has already been used.',
                ]);
        }

        /*
         * Remove the used recovery code.
         */
        unset(
            $storedCodes[$matchedIndex]
        );

        $storedCodes = array_values(
            $storedCodes
        );

        $user->update([
            'two_factor_recovery_codes' =>
                json_encode($storedCodes),
        ]);

        return $this->completeLogin(
            $request,
            $user
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Complete Login
    |--------------------------------------------------------------------------
    */

    private function completeLogin(
        Request $request,
        User $user
    ): RedirectResponse {

        $request->session()->regenerate();

        $loginToken = Str::random(64);

        $user->update([
            'login_token' => $loginToken,
        ]);

        Auth::guard('web')->login($user);

        $request->session()->put(
            'login_token',
            $loginToken
        );

        $request->session()->forget([
            'two_factor_pending_user_id',
        ]);

        return redirect()->intended(
            route(
                'dashboard',
                absolute: false
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | 2FA Setup
    |--------------------------------------------------------------------------
    */

    public function setup(
        Request $request
    ): View|RedirectResponse {

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (
            $user->two_factor_enabled &&
            !empty($user->two_factor_secret)
        ) {
            return view(
                'auth.two-factor-settings',
                [
                    'enabled' => true,
                ]
            );
        }

        $google2fa = new Google2FA();

        $secretKey = $request->session()->get(
            'two_factor_setup_secret'
        );

        if (!$secretKey) {

            $secretKey =
                $google2fa->generateSecretKey();

            $request->session()->put(
                'two_factor_setup_secret',
                $secretKey
            );
        }

        $qrCode =
            $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $secretKey
            );

        return view(
            'auth.two-factor-settings',
            [
                'enabled' => false,
                'qrCode' => $qrCode,
                'secretKey' => $secretKey,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Confirm 2FA Setup
    |--------------------------------------------------------------------------
    */

    public function confirm(
        Request $request
    ): RedirectResponse {

        $request->validate([
            'code' => [
                'required',
                'digits:6',
            ],
        ]);

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $secretKey = $request->session()->get(
            'two_factor_setup_secret'
        );

        if (!$secretKey) {
            return redirect()
                ->route('two-factor.setup')
                ->withErrors([
                    'code' =>
                        'Your 2FA setup session has expired. Please scan the QR code again.',
                ]);
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $secretKey,
            $request->code
        );

        if (!$valid) {
            return back()
                ->withErrors([
                    'code' =>
                        'Invalid verification code. Please enter the current code from Google Authenticator.',
                ]);
        }

        /*
         * Generate recovery codes.
         */
        $plainRecoveryCodes = [];

        $hashedRecoveryCodes = [];

        for ($i = 0; $i < 8; $i++) {

            $code =
                strtoupper(
                    Str::random(4)
                )
                . '-'
                .
                strtoupper(
                    Str::random(4)
                );

            $plainRecoveryCodes[] = $code;

            $hashedRecoveryCodes[] =
                Hash::make($code);
        }

        $user->update([
            'two_factor_enabled' => true,

            'two_factor_secret' =>
                $secretKey,

            'two_factor_recovery_codes' =>
                json_encode(
                    $hashedRecoveryCodes
                ),

            'two_factor_confirmed_at' =>
                now(),
        ]);

        $request->session()->forget(
            'two_factor_setup_secret'
        );

        /*
         * Only plain codes are placed into
         * the session temporarily so they can
         * be shown once.
         */
        $request->session()->put(
            'two_factor_recovery_codes',
            $plainRecoveryCodes
        );

        return redirect()
            ->route('two-factor.recovery')
            ->with(
                'success',
                'Two-factor authentication has been enabled successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Recovery Codes Display
    |--------------------------------------------------------------------------
    */

    public function recovery(
        Request $request
    ): View|RedirectResponse {

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $recoveryCodes =
            $request->session()->pull(
                'two_factor_recovery_codes'
            );

        if (!$recoveryCodes) {
            return redirect()
                ->route('two-factor.setup')
                ->with(
                    'success',
                    'Your recovery codes have already been displayed.'
                );
        }

        return view(
            'auth.two-factor-recovery',
            compact(
                'recoveryCodes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Disable 2FA
    |--------------------------------------------------------------------------
    */

    public function disable(
        Request $request
    ): RedirectResponse {

        $request->validate([
            'password' => [
                'required',
            ],
        ]);

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'password' =>
                        'The password you entered is incorrect.',
                ]);
        }

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        $request->session()->forget([
            'two_factor_setup_secret',
            'two_factor_recovery_codes',
        ]);

        return redirect()
            ->route('two-factor.setup')
            ->with(
                'success',
                'Two-factor authentication has been disabled.'
            );
    }
}
