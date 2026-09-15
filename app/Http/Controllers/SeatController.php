<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Seat;
use App\Models\Student;
use App\Models\Fees;
use App\Models\SeatAssignment;
use App\Models\FeeCycle;
use App\Models\StudentWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{
    public function index()
    {
        $libraries = Library::latest()->get();

        $students = Student::latest()->get();

        $fees = Fees::with('library')
            ->where('fees', 'Monthly')
            ->orderBy('library_id')
            ->orderBy('amount')
            ->get();

       $seats = Seat::with([
    'library',
    'activeAssignment.student',
    'activeAssignment.fees',
])
->when(request('library_id'), function ($query) {
    $query->where(
        'library_id',
        request('library_id')
    );
})
->when(request('status'), function ($query) {
    $query->where(
        'status',
        request('status')
    );
})
->latest()
->get();

        return view(
            'admin.seat.index',
            compact(
                'libraries',
                'students',
                'fees',
                'seats'
            )
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'library_id' => 'required|exists:libraries,id',
            'seat_number' => 'required|string|max:50',
        ]);

        Seat::create([
            'library_id' => $data['library_id'],
            'seat_number' => $data['seat_number'],
            'status' => 'available',
        ]);

        return redirect()
            ->route('admin.seat.index')
            ->with(
                'success',
                'Seat added successfully.'
            );
    }

    public function assign(Request $request, Seat $seat)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fees_id' => 'required|exists:fees,id',
            'assign_date' => 'required|date',
        ]);

        if ($seat->activeAssignment) {
            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'This seat is already occupied.'
                );
        }

        $alreadyAssigned = SeatAssignment::where(
            'student_id',
            $data['student_id']
        )
        ->where('status', 'active')
        ->exists();

        if ($alreadyAssigned) {
            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'This student is already assigned to another seat.'
                );
        }

        $feePlan = Fees::where('id', $data['fees_id'])
            ->where('library_id', $seat->library_id)
            ->where('fees', 'Monthly')
            ->first();

        if (!$feePlan) {
            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'Invalid monthly fee plan selected for this library.'
                );
        }

        $assignment = SeatAssignment::create([
            'seat_id' => $seat->id,
            'student_id' => $data['student_id'],
            'fees_id' => $feePlan->id,
            'assign_date' => $data['assign_date'],
            'status' => 'active',
        ]);

        StudentWallet::firstOrCreate(
            [
                'student_id' => $data['student_id'],
            ],
            [
                'balance' => 0,
            ]
        );

        $periodStart = Carbon::parse(
            $data['assign_date']
        );

        $periodEnd = $periodStart
            ->copy()
            ->addMonth()
            ->subDay();

        FeeCycle::create([
            'student_id' => $data['student_id'],
            'seat_assignment_id' => $assignment->id,
            'fees_id' => $feePlan->id,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'amount' => $feePlan->amount,
            'paid_amount' => 0,
            'status' => 'pending',
        ]);

        $seat->update([
            'status' => 'occupied',
        ]);

        return redirect()
            ->route('admin.seat.index')
            ->with(
                'success',
                'Student assigned successfully.'
            );
    }

    public function destroy(Seat $seat)
    {
        if ($seat->activeAssignment) {
            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'This seat cannot be deleted while a student is assigned.'
                );
        }

        $seat->delete();

        return redirect()
            ->route('admin.seat.index')
            ->with(
                'success',
                'Seat deleted successfully.'
            );
    }

    public function release(Seat $seat)
    {
        $assignment = $seat->activeAssignment;

        if (!$assignment) {
            $seat->update([
                'status' => 'available',
            ]);

            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'No active student was found. Seat has been marked as available.'
                );
        }

        $assignment->update([
            'status' => 'inactive',
        ]);

        $seat->update([
            'status' => 'available',
        ]);

        return redirect()
            ->route('admin.seat.index')
            ->with(
                'success',
                'Student released from seat successfully.'
            );
    }

    public function bulkChangePlan(Request $request)
    {
        $data = $request->validate([
            'library_id' => 'required|exists:libraries,id',
            'fees_id' => 'required|exists:fees,id',
        ]);

        $feePlan = Fees::where('id', $data['fees_id'])
            ->where('library_id', $data['library_id'])
            ->where('fees', 'Monthly')
            ->first();

        if (!$feePlan) {
            return back()
                ->with(
                    'error',
                    'Invalid monthly fee plan selected for this library.'
                );
        }

        $updated = 0;

        DB::transaction(function () use (
            $data,
            $feePlan,
            &$updated
        ) {

            SeatAssignment::where(
                'status',
                'active'
            )
            ->whereHas('seat', function ($query) use ($data) {

                $query->where(
                    'library_id',
                    $data['library_id']
                );

            })
            ->chunkById(
                100,
                function ($assignments) use (
                    $feePlan,
                    &$updated
                ) {

                    foreach ($assignments as $assignment) {

                        $assignment->update([
                            'fees_id' => $feePlan->id,
                        ]);

                        $currentCycle = FeeCycle::where(
                            'seat_assignment_id',
                            $assignment->id
                        )
                        ->whereIn(
                            'status',
                            [
                                'pending',
                                'partial',
                            ]
                        )
                        ->orderBy(
                            'period_start'
                        )
                        ->first();

                        if ($currentCycle) {

                            $paidAmount = (float)
                                $currentCycle->paid_amount;

                            $newAmount = (float)
                                $feePlan->amount;

                            if ($paidAmount >= $newAmount) {

                                $newStatus = 'paid';

                            } elseif ($paidAmount > 0) {

                                $newStatus = 'partial';

                            } else {

                                $newStatus = 'pending';
                            }

                            $currentCycle->update([
                                'fees_id' => $feePlan->id,
                                'amount' => $newAmount,
                                'status' => $newStatus,
                            ]);
                        }

                        $updated++;
                    }
                }
            );
        });

        return back()
            ->with(
                'success',
                $updated .
                ' student(s) monthly fee plan changed successfully.'
            );
    }
}