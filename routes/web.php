<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\FeeReportController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LibraryLayoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RazorpayWebhookController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentTestController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\WalletController;
use App\Models\Test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Welcome / Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $tests = Test::with([
        'testSeries',
        'attempts' => function ($query) {
            $query
                ->where('status', 'submitted')
                ->whereNotNull('user_id')
                ->with('user')
                ->orderByDesc('percentage')
                ->orderByDesc('obtained_marks')
                ->orderBy('time_taken');
        }
    ])
        ->where('status', true)
        ->latest()
        ->get();

    return view('welcome', compact('tests'));
});


Route::middleware([
    'auth',
    'active',
    'single.session',
])->group(function () {

    Route::get(
        '/settings/two-factor',
        [TwoFactorController::class, 'setup']
    )->name('two-factor.setup');

    Route::post(
        '/settings/two-factor/confirm',
        [TwoFactorController::class, 'confirm']
    )->name('two-factor.confirm');

    Route::get(
        '/settings/two-factor/recovery',
        [TwoFactorController::class, 'recovery']
    )->name('two-factor.recovery');

    Route::post(
        '/settings/two-factor/disable',
        [TwoFactorController::class, 'disable']
    )->name('two-factor.disable');
});

Route::get(
    '/two-factor/recovery-challenge',
    [TwoFactorController::class, 'recoveryChallenge']
)->name('two-factor.recovery-challenge');

Route::post(
    '/two-factor/recovery-verify',
    [TwoFactorController::class, 'verifyRecoveryCode']
)->name('two-factor.recovery-verify');

/*
|--------------------------------------------------------------------------
| Razorpay Webhook
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\TestTopperController;

Route::get(
    '/test-toppers',
    [TestTopperController::class, 'index']
)->name('test.toppers');


Route::get(
    '/two-factor/challenge',
    [TwoFactorController::class, 'challenge']
)->name('two-factor.challenge');

Route::post(
    '/two-factor/verify',
    [TwoFactorController::class, 'verify']
)->name('two-factor.verify');

Route::post(
    '/razorpay/webhook',
    [RazorpayWebhookController::class, 'handle']
)->name('razorpay.webhook');

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/

Route::view('/terms-and-conditions', 'terms')
    ->name('terms');

Route::view('/privacy-policy', 'privacy')
    ->name('privacy');

Route::view('/refund-cancellation-policy', 'refund')
    ->name('refund');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [UserAuthController::class, 'index']
)
    ->middleware(['auth', 'verified', 'single.session'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Short URL - Public
|--------------------------------------------------------------------------
*/

Route::get(
    '/s/{shortCode}',
    [
        \App\Http\Controllers\ShortUrlController::class,
        'redirect'
    ]
)->name('short-url.redirect');

Route::get(
    '/s/{shortCode}/password',
    [
        \App\Http\Controllers\ShortUrlController::class,
        'passwordPage'
    ]
)->name('short-url.password');

Route::post(
    '/s/{shortCode}/password',
    [
        \App\Http\Controllers\ShortUrlController::class,
        'verifyPassword'
    ]
)->name('short-url.password.verify');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'active',
    'single.session'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Subscription
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/subscription',
        [PaymentController::class, 'index']
    )->name('subscription.index');

    Route::post(
        '/subscription/create-order',
        [PaymentController::class, 'createOrder']
    )->name('subscription.create-order');

    Route::post(
        '/subscription/verify-payment',
        [PaymentController::class, 'verifyPayment']
    )->name('subscription.verify-payment');

    /*
    |--------------------------------------------------------------------------
    | Short URLs
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/short-urls',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'index'
        ]
    )->name('short-url.index');

    Route::post(
        '/short-urls',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'store'
        ]
    )->name('short-url.store');

    Route::get(
        '/short-urls/{shortUrl}/analytics',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'analytics'
        ]
    )->name('short-url.analytics');

    Route::get(
        '/short-urls/{shortUrl}/qr',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'qrCode'
        ]
    )->name('short-url.qr');

    Route::get(
        '/short-urls/{shortUrl}/qr/download',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'downloadQr'
        ]
    )->name('short-url.qr.download');

    Route::delete(
        '/short-urls/{shortUrl}',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'destroy'
        ]
    )->name('short-url.destroy');

    Route::patch(
        '/short-urls/{shortUrl}/toggle',
        [
            \App\Http\Controllers\ShortUrlController::class,
            'toggleStatus'
        ]
    )->name('short-url.toggle');

    /*
    |--------------------------------------------------------------------------
    | Student Tests
    |--------------------------------------------------------------------------
    |
    | Online Test System is independent of Library Student system.
    | Tests use authenticated User.
    |
    */

    Route::middleware([
        'active',
        'single.session'
    ])->group(function () {

        /*
        |----------------------------------------------------------------------
        | Test List
        |----------------------------------------------------------------------
        */

        Route::get(
            '/tests',
            [StudentTestController::class, 'index']
        )->name('student.tests.index');

        /*
        |----------------------------------------------------------------------
        | Test Details
        |----------------------------------------------------------------------
        */

        Route::get(
            '/tests/{test}',
            [StudentTestController::class, 'show']
        )->name('student.test.show');

        /*
        |----------------------------------------------------------------------
        | Start Test
        |----------------------------------------------------------------------
        */

        Route::post(
            '/tests/{test}/start',
            [StudentTestController::class, 'start']
        )->name('student.test.start');

        /*
        |----------------------------------------------------------------------
        | Test Attempt Page
        |----------------------------------------------------------------------
        */

        Route::get(
            '/test-attempt/{attempt}',
            [StudentTestController::class, 'attempt']
        )->name('student.test.attempt');

        /*
        |----------------------------------------------------------------------
        | Load One Question
        |----------------------------------------------------------------------
        |
        | IMPORTANT:
        | This route must remain inside authenticated routes.
        |
        */

        Route::get(
            '/tests/attempt/{attempt}/question/{number}',
            [StudentTestController::class, 'question']
        )->name('student.test.question');

        /*
        |----------------------------------------------------------------------
        | Save Answer
        |----------------------------------------------------------------------
        */

        Route::post(
            '/test-attempt/{attempt}/save-answer',
            [StudentTestController::class, 'saveAnswer']
        )->name('student.test.save-answer');

        /*
        |----------------------------------------------------------------------
        | Submit Test
        |----------------------------------------------------------------------
        */

        Route::post(
            '/test-attempt/{attempt}/submit',
            [StudentTestController::class, 'submit']
        )->name('student.test.submit');

        /*
        |----------------------------------------------------------------------
        | Result
        |----------------------------------------------------------------------
        */

        Route::get(
            '/test-attempt/{attempt}/result',
            [StudentTestController::class, 'result']
        )->name('student.test.result');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'admin',
    'single.session'
])->group(function () {




    /*
    |--------------------------------------------------------------------------
    | User Accounts
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/users',
        [UserController::class, 'index']
    )->name('admin.users.index');

    Route::patch(
        '/admin/users/{user}/toggle-status',
        [UserController::class, 'toggleStatus']
    )->name('admin.users.toggle-status');

    Route::patch(
        '/admin/users/{user}/toggle-tests',
        [UserController::class, 'toggleTests']
    )->name('admin.users.toggle-tests');

    Route::post(
        '/admin/users/{user}/grant-free-subscription',
        [UserController::class, 'grantFreeSubscription']
    )->name('admin.users.grant-free-subscription');

    Route::patch(
        '/admin/users/{user}/revoke-free-subscription',
        [UserController::class, 'revokeFreeSubscription']
    )->name('admin.users.revoke-free-subscription');

    /*
    |--------------------------------------------------------------------------
    | Subscription Plans
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/subscription-plans',
        [
            \App\Http\Controllers\Admin\SubscriptionPlanController::class,
            'index'
        ]
    )->name('admin.subscription-plans.index');

    Route::post(
        '/admin/subscription-plans',
        [
            \App\Http\Controllers\Admin\SubscriptionPlanController::class,
            'store'
        ]
    )->name('admin.subscription-plans.store');

    Route::put(
        '/admin/subscription-plans/{subscriptionPlan}',
        [
            \App\Http\Controllers\Admin\SubscriptionPlanController::class,
            'update'
        ]
    )->name('admin.subscription-plans.update');

    Route::patch(
        '/admin/subscription-plans/{subscriptionPlan}/toggle-status',
        [
            \App\Http\Controllers\Admin\SubscriptionPlanController::class,
            'toggleStatus'
        ]
    )->name('admin.subscription-plans.toggle-status');

    /*
    |--------------------------------------------------------------------------
    | Library Students
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/students',
        [StudentController::class, 'index']
    )->name('admin.students');

    Route::get(
        '/admin/student',
        [StudentController::class, 'index']
    )->name('admin.student.index');

    Route::get(
        '/students/create',
        [StudentController::class, 'create']
    )->name('student.create');

    Route::post(
        '/add_student',
        [StudentController::class, 'store']
    )->name('student.store');

    Route::get(
        '/students/check-aadhar',
        [StudentController::class, 'checkAadhar']
    )->name('student.check-aadhar');

    Route::get(
        '/students/{student}/edit',
        [StudentController::class, 'edit']
    )->name('student.edit');

    Route::put(
        '/students/{student}',
        [StudentController::class, 'update']
    )->name('student.update');

    Route::delete(
        '/students/{student}',
        [StudentController::class, 'destroy']
    )->name('student.destroy');

    /*
    |--------------------------------------------------------------------------
    | Student Fees
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/students/{student}/fees',
        function (\App\Models\Student $student) {

            $feeCycles = \App\Models\FeeCycle::with([
                'fees',
                'seatAssignment.seat'
            ])
                ->where('student_id', $student->id)
                ->latest('period_start')
                ->paginate(20);

            return view(
                'admin.fees.student',
                compact(
                    'student',
                    'feeCycles'
                )
            );
        }
    )->name('admin.student.fees');

    /*
    |--------------------------------------------------------------------------
    | Student Wallet
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/students/{student}/wallet',
        [WalletController::class, 'history']
    )->name('admin.wallet.history');

    Route::post(
        '/students/{student}/wallet/add-money',
        [WalletController::class, 'addMoney']
    )->name('admin.wallet.add-money');

    /*
    |--------------------------------------------------------------------------
    | Fee Cycle
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/fee-cycles/{feeCycle}/debit',
        [WalletController::class, 'debitForFee']
    )->name('admin.fee-cycle.debit');

    /*
    |--------------------------------------------------------------------------
    | Fee & Wallet Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fee-wallet-report',
        [FeeReportController::class, 'index']
    )->name('admin.fee-wallet-report');


/*
|--------------------------------------------------------------------------
| All Student Wallet History
|--------------------------------------------------------------------------
*/

Route::get(
    '/all-student-history',
    [WalletController::class, 'allHistory']
)->name('admin.all-student-history');

    /*
    |--------------------------------------------------------------------------
    | Seat Management
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/seat',
        [SeatController::class, 'index']
    )->name('admin.seat.index');

    Route::get(
        '/admin/seat/create',
        [SeatController::class, 'create']
    )->name('admin.seat.create');

    Route::post(
        '/admin/seat',
        [SeatController::class, 'store']
    )->name('admin.seat.store');

    Route::delete(
        '/admin/seat/{seat}',
        [SeatController::class, 'destroy']
    )->name('admin.seat.destroy');

    /*
    |--------------------------------------------------------------------------
    | Seat Assignment
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/seat-map/{seat}/assign',
        [SeatController::class, 'assign']
    )->name('admin.seat-map.assign');

    Route::post(
        '/admin/seat-map/{seat}/release',
        [SeatController::class, 'release']
    )->name('admin.seat-map.release');

    /*
    |--------------------------------------------------------------------------
    | Bulk Monthly Fee Plan Change
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/seat-map/change-plan',
        [SeatController::class, 'bulkChangePlan']
    )->name('admin.seat-map.change-plan');

    Route::post(
        '/seats/bulk-change-plan',
        [SeatController::class, 'bulkChangePlan']
    )->name('admin.seat.bulk-change-plan');

    /*
    |--------------------------------------------------------------------------
    | Seat Map / Library Layout
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/seat-map',
        [LibraryLayoutController::class, 'view']
    )->name('admin.seat-map.view');

    Route::get(
        '/admin/seat-map/editor',
        [LibraryLayoutController::class, 'editor']
    )->name('admin.seat-map.editor');

    Route::post(
        '/admin/seat-map/editor',
        [LibraryLayoutController::class, 'save']
    )->name('admin.seat-map.save');

    /*
    |--------------------------------------------------------------------------
    | Fees
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/fees',
        [FeesController::class, 'index']
    )->name('admin.fees.index');

    Route::post(
        '/admin/fees',
        [FeesController::class, 'store']
    )->name('admin.fees.store');

    Route::delete(
        '/admin/fees/{fees}',
        [FeesController::class, 'destroy']
    )->name('admin.fees.destroy');

    /*
    |--------------------------------------------------------------------------
    | Library
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/index',
        [LibraryController::class, 'index']
    )->name('admin.library.index');

    Route::post(
        '/admin/store',
        [LibraryController::class, 'store']
    )->name('admin.library.store');

    Route::delete(
        '/admin/library/{library}',
        [LibraryController::class, 'destroy']
    )->name('admin.library.destroy');

    /*
    |--------------------------------------------------------------------------
    | Test Series
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/test-series',
        [
            \App\Http\Controllers\TestSeriesController::class,
            'index'
        ]
    )->name('admin.test-series.index');

    Route::post(
        '/admin/test-series',
        [
            \App\Http\Controllers\TestSeriesController::class,
            'store'
        ]
    )->name('admin.test-series.store');

    Route::put(
        '/admin/test-series/{testSeries}',
        [
            \App\Http\Controllers\TestSeriesController::class,
            'update'
        ]
    )->name('admin.test-series.update');

    Route::patch(
        '/admin/test-series/{testSeries}/status',
        [
            \App\Http\Controllers\TestSeriesController::class,
            'toggleStatus'
        ]
    )->name('admin.test-series.status');

    Route::delete(
        '/admin/test-series/{testSeries}',
        [
            \App\Http\Controllers\TestSeriesController::class,
            'destroy'
        ]
    )->name('admin.test-series.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Tests
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/test-series/{testSeries}/tests',
        [
            \App\Http\Controllers\TestController::class,
            'index'
        ]
    )->name('admin.tests.index');

    Route::post(
        '/admin/test-series/{testSeries}/tests',
        [
            \App\Http\Controllers\TestController::class,
            'store'
        ]
    )->name('admin.tests.store');

    Route::put(
        '/admin/tests/{test}',
        [
            \App\Http\Controllers\TestController::class,
            'update'
        ]
    )->name('admin.tests.update');

    Route::patch(
        '/admin/tests/{test}/status',
        [
            \App\Http\Controllers\TestController::class,
            'toggleStatus'
        ]
    )->name('admin.tests.status');

    Route::delete(
        '/admin/tests/{test}',
        [
            \App\Http\Controllers\TestController::class,
            'destroy'
        ]
    )->name('admin.tests.destroy');

    /*
    |--------------------------------------------------------------------------
    | Questions
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/tests/{test}/questions/import/template',
        [QuestionController::class, 'downloadTemplate']
    )->name('admin.questions.import.template');

    Route::post(
        '/admin/tests/{test}/questions/import',
        [QuestionController::class, 'import']
    )->name('admin.questions.import');

    Route::get(
        '/admin/tests/{test}/questions/import/remaining/{file}',
        [QuestionController::class, 'downloadRemaining']
    )->name('admin.questions.import.remaining');

    Route::get(
        '/admin/tests/{test}/questions',
        [QuestionController::class, 'index']
    )->name('admin.questions.index');

    Route::post(
        '/admin/tests/{test}/questions',
        [QuestionController::class, 'store']
    )->name('admin.questions.store');

    Route::put(
        '/admin/questions/{question}',
        [QuestionController::class, 'update']
    )->name('admin.questions.update');

    Route::delete(
        '/admin/questions/{question}',
        [QuestionController::class, 'destroy']
    )->name('admin.questions.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Test Results
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/test-results',
        [
            \App\Http\Controllers\Admin\TestAttemptController::class,
            'index'
        ]
    )->name('admin.test-results.index');

    Route::get(
        '/admin/test-results/{attempt}',
        [
            \App\Http\Controllers\Admin\TestAttemptController::class,
            'show'
        ]
    )->name('admin.test-results.show');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
