<?php

namespace App\Http\Middleware;

use App\Models\Test;
use App\Models\TestAttempt;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTestAccess
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Active Account Check
        |--------------------------------------------------------------------------
        */

        if (!$user->is_active) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account has been disabled. Please contact the administrator.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Master Test Access Check
        |--------------------------------------------------------------------------
        */

        if (!$user->tests_enabled) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Tests access is disabled for your account.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Test Listing
        |--------------------------------------------------------------------------
        |
        | /tests page subscription ke bina open rahega.
        |
        */

        if ($request->routeIs('student.tests.index')) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Test
        |--------------------------------------------------------------------------
        */

        $test = $request->route('test');

        if (!$test instanceof Test && $test) {
            $test = Test::with('testSeries')->find($test);
        }

        /*
        |--------------------------------------------------------------------------
        | Free Individual Test
        |--------------------------------------------------------------------------
        */

        if ($test instanceof Test) {
            $test->loadMissing('testSeries');

            if ($test->is_free) {
                return $next($request);
            }

            /*
            |--------------------------------------------------------------------------
            | Free Test Series
            |--------------------------------------------------------------------------
            */

            if (
                $test->testSeries &&
                $test->testSeries->is_free
            ) {
                return $next($request);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Test Attempt
        |--------------------------------------------------------------------------
        */

        $attempt = $request->route('attempt');

        if (!$attempt instanceof TestAttempt && $attempt) {
            $attempt = TestAttempt::find($attempt);
        }

        /*
        |--------------------------------------------------------------------------
        | Free Test Attempt
        |--------------------------------------------------------------------------
        */

        if ($attempt instanceof TestAttempt) {
            $attempt->loadMissing([
                'test.testSeries',
            ]);

            $attemptTest = $attempt->test;

            if ($attemptTest) {

                /*
                |--------------------------------------------------------------------------
                | Individual Free Test
                |--------------------------------------------------------------------------
                */

                if ($attemptTest->is_free) {
                    return $next($request);
                }

                /*
                |--------------------------------------------------------------------------
                | Free Series
                |--------------------------------------------------------------------------
                */

                if (
                    $attemptTest->testSeries &&
                    $attemptTest->testSeries->is_free
                ) {
                    return $next($request);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Paid Test Subscription Check
        |--------------------------------------------------------------------------
        */

        $subscription = $user->latestSubscription()
            ->with('plan')
            ->first();

        if (
            !$subscription ||
            !$subscription->isActive()
        ) {
            return redirect()
                ->route('subscription.index')
                ->with(
                    'error',
                    'Please purchase an active test subscription to continue.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Test Access Plan Check
        |--------------------------------------------------------------------------
        */

        if (
            !$subscription->plan ||
            !$subscription->plan->tests_access
        ) {
            return redirect()
                ->route('subscription.index')
                ->with(
                    'error',
                    'Your current subscription does not include test access.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Allow Paid Test
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}
