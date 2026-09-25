<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Seat;
use App\Models\Student;
use App\Models\Fees;
use App\Models\SeatAssignment;
use App\Models\StudentWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Libraries
        |--------------------------------------------------------------------------
        */

        $libraries = Library::latest()->get();


        /*
        |--------------------------------------------------------------------------
        | All Students
        |--------------------------------------------------------------------------
        |
        | Used wherever the complete student list is required.
        |
        */

        $students = Student::latest()->get();


        /*
        |--------------------------------------------------------------------------
        | Available Students
        |--------------------------------------------------------------------------
        |
        | Only students who do NOT have an active seat assignment.
        |
        | If a student is released from a seat, their assignment becomes
        | inactive and they will automatically appear here again.
        |
        */

        $availableStudents = Student::whereDoesntHave(
            'seatAssignments',
            function ($query) {
                $query->where('status', 'active');
            }
        )
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Monthly Fee Plans
        |--------------------------------------------------------------------------
        */

        $fees = Fees::with('library')
            ->where('fees', 'Monthly')
            ->orderBy('library_id')
            ->orderBy('amount')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Seats
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.seat.index',
            compact(
                'libraries',
                'students',
                'availableStudents',
                'fees',
                'seats'
            )
        );
    }


    public function seatMap()
{
    $libraries = Library::orderBy('name')->get();

    $selectedLibraryId = request('library_id');

    $seats = Seat::with([
        'library',
        'activeAssignment.student',
        'activeAssignment.fees',
    ])
        ->when($selectedLibraryId, function ($query) use ($selectedLibraryId) {
            $query->where('library_id', $selectedLibraryId);
        })
        ->orderBy('seat_number')
        ->get();

    return view(
        'admin.seat-map.index',
        compact(
            'libraries',
            'seats',
            'selectedLibraryId'
        )
    );
}

    /*
    |--------------------------------------------------------------------------
    | Add Seat
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Assign Student
    |--------------------------------------------------------------------------
    */

    public function assign(
        Request $request,
        Seat $seat
    ) {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fees_id' => 'required|exists:fees,id',
            'assign_date' => 'required|date',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check Seat
        |--------------------------------------------------------------------------
        */

        if ($seat->activeAssignment) {

            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'This seat is already occupied.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Student
        |--------------------------------------------------------------------------
        |
        | A student can have only one active seat.
        |
        */

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


        /*
        |--------------------------------------------------------------------------
        | Validate Fee Plan
        |--------------------------------------------------------------------------
        |
        | Fee plan must belong to the same library as the seat.
        |
        */

        $feePlan = Fees::where(
            'id',
            $data['fees_id']
        )
            ->where(
                'library_id',
                $seat->library_id
            )
            ->where(
                'fees',
                'Monthly'
            )
            ->first();


        if (!$feePlan) {

            return redirect()
                ->route('admin.seat.index')
                ->with(
                    'error',
                    'Invalid monthly fee plan selected for this library.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Assignment + Wallet + Fee Cycles
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $data,
            $seat,
            $feePlan
        ) {

            /*
            |--------------------------------------------------------------------------
            | Create Seat Assignment
            |--------------------------------------------------------------------------
            */

            $assignment = SeatAssignment::create([
                'seat_id' => $seat->id,
                'student_id' => $data['student_id'],
                'fees_id' => $feePlan->id,
                'assign_date' => $data['assign_date'],
                'status' => 'active',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Student Wallet
            |--------------------------------------------------------------------------
            */

            StudentWallet::firstOrCreate(
                [
                    'student_id' => $data['student_id'],
                ],
                [
                    'balance' => 0,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Create Fee Cycles
            |--------------------------------------------------------------------------
            |
            | FeeService handles:
            |
            | First month:
            | Assignment date → month end
            |
            | Next months:
            | 1st → month end
            |
            | Existing cycle protection:
            | FeeService prevents duplicate cycles.
            |
            */

            app(\App\Services\FeeService::class)
                ->createCyclesForAssignment(
                    $assignment
                );


            /*
            |--------------------------------------------------------------------------
            | Mark Seat Occupied
            |--------------------------------------------------------------------------
            */

            $seat->update([
                'status' => 'occupied',
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Immediately Process Existing Wallet Balance
        |--------------------------------------------------------------------------
        |
        | If the student already had money in wallet,
        | pending/partial fees are automatically adjusted.
        |
        */

        try {

            app(\App\Services\FeeService::class)
                ->autoProcessStudentFees(
                    $data['student_id']
                );

        } catch (\Throwable $e) {

            report($e);
        }


        return redirect()
            ->route('admin.seat.index')
            ->with(
                'success',
                'Student assigned successfully. Applicable fee was calculated automatically.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Seat
    |--------------------------------------------------------------------------
    */

    public function destroy(Seat $seat)
    {
        /*
        |--------------------------------------------------------------------------
        | Do Not Delete Occupied Seat
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | Release Student
    |--------------------------------------------------------------------------
    */

    public function release(Seat $seat)
    {
        $assignment = $seat->activeAssignment;


        /*
        |--------------------------------------------------------------------------
        | No Active Assignment
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Close Assignment
        |--------------------------------------------------------------------------
        |
        | History remains preserved.
        |
        */

        $assignment->update([
            'status' => 'inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Mark Seat Available
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | Bulk Change Fee Plan
    |--------------------------------------------------------------------------
    */

    public function bulkChangePlan(Request $request)
    {
        $data = $request->validate([
            'library_id' => 'required|exists:libraries,id',
            'fees_id' => 'required|exists:fees,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validate New Fee Plan
        |--------------------------------------------------------------------------
        */

        $feePlan = Fees::query()
            ->where(
                'id',
                $data['fees_id']
            )
            ->where(
                'library_id',
                $data['library_id']
            )
            ->where(
                'fees',
                'Monthly'
            )
            ->first();


        if (!$feePlan) {

            return back()->with(
                'error',
                'Invalid monthly fee plan selected for this library.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Active Assignments
        |--------------------------------------------------------------------------
        */

        $assignments = SeatAssignment::query()
            ->with([
                'seat',
                'fees'
            ])
            ->where(
                'status',
                'active'
            )
            ->whereHas(
                'seat',
                function ($query) use ($data) {

                    $query->where(
                        'library_id',
                        $data['library_id']
                    );
                }
            )
            ->get();


        $updated = 0;

        $studentIds = [];


        /*
        |--------------------------------------------------------------------------
        | Change Plan
        |--------------------------------------------------------------------------
        */

        foreach ($assignments as $assignment) {

            /*
            |--------------------------------------------------------------------------
            | Already Same Plan
            |--------------------------------------------------------------------------
            */

            if (
                (int) $assignment->fees_id ===
                (int) $feePlan->id
            ) {
                continue;
            }


            try {

                app(\App\Services\FeeService::class)
                    ->changePlanFromCurrentMonth(
                        $assignment,
                        $feePlan
                    );


                $updated++;

                $studentIds[] =
                    $assignment->student_id;

            } catch (\Throwable $e) {

                report($e);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Immediately Process Wallet Balance
        |--------------------------------------------------------------------------
        |
        | Existing wallet balance will be used against
        | pending/partial fee cycles.
        |
        */

        foreach (
            array_unique($studentIds)
            as $studentId
        ) {

            try {

                app(\App\Services\FeeService::class)
                    ->autoProcessStudentFees(
                        (int) $studentId
                    );

            } catch (\Throwable $e) {

                report($e);
            }
        }


        return back()->with(
            'success',
            $updated .
            ' student(s) monthly fee plan changed successfully from the current month.'
        );
    }
}
