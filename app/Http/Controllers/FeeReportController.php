<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Library;
use App\Models\FeeCycle;

class FeeReportController extends Controller
{
    public function index()
{
    // All libraries for filter dropdown
    $libraries = Library::orderBy('name')->get();

    $students = Student::with('wallet')
        ->whereHas('seatAssignments', function ($query) {

            // Only active seat assignments
            $query->where('status', 'active');

            // Library filter
            if (request('library_id')) {

                $query->whereHas('seat', function ($query) {

                    $query->where(
                        'library_id',
                        request('library_id')
                    );

                });
            }

        })
        ->orderBy('name')
        ->get();

    $studentReports = $students->map(function ($student) {

        $feeCycle = FeeCycle::where('student_id', $student->id)
            ->whereIn('status', ['pending', 'partial'])
            ->orderBy('period_start')
            ->first();

        $walletBalance = (float) ($student->wallet->balance ?? 0);

        $dueAmount = 0;

        if ($feeCycle) {
            $dueAmount = max(
                0,
                (float) $feeCycle->amount -
                (float) $feeCycle->paid_amount
            );
        }

        if ($dueAmount <= 0) {
            $status = 'Paid';
        } elseif ($walletBalance >= $dueAmount) {
            $status = 'Ready';
        } else {
            $status = 'Due';
        }

        return [
            'student' => $student,
            'wallet_balance' => $walletBalance,
            'due_amount' => $dueAmount,
            'status' => $status,
        ];
    });

    return view('admin.fees.wallet-report', compact(
        'studentReports',
        'libraries'
    ));
}
}