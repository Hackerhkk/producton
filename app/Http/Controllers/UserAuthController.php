<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Seat;
use App\Models\Student;
use App\Models\Fees;
use App\Models\FeeCycle;
use App\Models\StudentWallet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ShortUrl;

class UserAuthController extends Controller
{
    public function index()
    {
        // =========================
        // NORMAL USER
        // =========================

        if (Auth::check() && Auth::user()->role == 'user') {

    $userId = Auth::id();

    // Total Short URLs
    $shortUrlCount = ShortUrl::where(
        'user_id',
        $userId
    )->count();

    // Total Clicks
    $shortUrlClicks = ShortUrl::where(
        'user_id',
        $userId
    )->sum('clicks');

    // Today's Clicks
    $todayShortUrlClicks = ShortUrl::where(
        'user_id',
        $userId
    )
    ->withCount([
        'clicks as today_clicks' => function ($query) {
            $query->whereDate(
                'clicked_at',
                Carbon::today()
            );
        }
    ])
    ->get()
    ->sum('today_clicks');

    return view(
        'dashboard',
        compact(
            'shortUrlCount',
            'shortUrlClicks',
            'todayShortUrlClicks'
        )
    );
}


        // =========================
        // ADMIN
        // =========================

        if (Auth::check() && Auth::user()->role == 'admin') {

            // =========================
            // BASIC COUNTS
            // =========================

            $studentCount = Student::count();

            $libraryCount = Library::count();

            $seatCount = Seat::count();

            $occupiedSeatCount = Seat::where(
                'status',
                'occupied'
            )->count();

            $availableSeatCount = Seat::where(
                'status',
                'available'
            )->count();

            $feeCount = Fees::where(
                'fees',
                'Monthly'
            )->count();


            // =========================
            // ACTIVE STUDENTS
            // =========================

            $activeStudentCount = Student::whereHas(
                'seatAssignments',
                function ($query) {
                    $query->where(
                        'status',
                        'active'
                    );
                }
            )->count();


            // =========================
            // TOTAL WALLET BALANCE
            // =========================

            $totalWalletBalance = StudentWallet::sum(
                'balance'
            );


            // =========================
            // PENDING FEES
            // =========================

            $pendingFeeAmount = FeeCycle::whereIn(
                'status',
                [
                    'pending',
                    'partial',
                ]
            )
            ->get()
            ->sum(function ($cycle) {

                return max(
                    0,
                    (float) $cycle->amount -
                    (float) $cycle->paid_amount
                );
            });


            // =========================
            // PAID THIS MONTH
            // =========================

            $paidThisMonth = FeeCycle::where(
                'status',
                'paid'
            )
            ->whereNotNull('paid_date')
            ->whereMonth(
                'paid_date',
                Carbon::now()->month
            )
            ->whereYear(
                'paid_date',
                Carbon::now()->year
            )
            ->sum('paid_amount');


            // =========================
            // FEE CHART
            // =========================

          // =========================
// 7-DAY FEE COLLECTION CHART
// =========================

$startDate = Carbon::today()->subDays(6);
$endDate = Carbon::today();

$feeChart = collect();

for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

    $amount = FeeCycle::where(
        'status',
        'paid'
    )
    ->whereDate(
        'paid_date',
        $date->toDateString()
    )
    ->sum('paid_amount');

    $feeChart->push([
        'date' => $date->copy(),
        'amount' => (float) $amount,
    ]);
}

            // =========================
            // ADMIN DASHBOARD
            // =========================

            return view(
                'admin.dashboard',
                compact(
                    'studentCount',
                    'libraryCount',
                    'seatCount',
                    'occupiedSeatCount',
                    'availableSeatCount',
                    'feeCount',
                    'activeStudentCount',
                    'totalWalletBalance',
                    'pendingFeeAmount',
                    'paidThisMonth',
                    'feeChart'
                )
            );
        }


        // =========================
        // NOT LOGGED IN
        // =========================

        return redirect()->route('login');
    }
}