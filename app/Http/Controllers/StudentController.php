<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use App\Models\Library;
use App\Models\Seat;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $libraries = Library::orderBy('name')->get();

        $seats = Seat::with([
            'library',
            'activeAssignment.student',
            'activeAssignment.fees',
        ])
            ->when(request('library_id'), function ($query) {
                $query->where('library_id', request('library_id'));
            })
            ->orderBy('library_id')
            ->orderBy('seat_number')
            ->get();

        $fees = Fees::orderBy('amount')->get();

        $students = Student::with([
            'wallet',
            'seatAssignments' => function ($query) {
                $query->where('status', 'active')
                    ->with([
                        'seat.library',
                        'fees',
                    ]);
            },
        ])
            ->when(request('library_id'), function ($query) {
                $query->whereHas('seatAssignments', function ($query) {
                    $query->where('status', 'active')
                        ->whereHas('seat', function ($query) {
                            $query->where(
                                'library_id',
                                request('library_id')
                            );
                        });
                });
            })
            ->when(request('search'), function ($query) {
                $search = request('search');

                $query->where(function ($query) use ($search) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'mobile',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'aadhar_no',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhereHas(
                            'seatAssignments',
                            function ($query) use ($search) {
                                $query->where(
                                    'status',
                                    'active'
                                )
                                    ->whereHas(
                                        'seat',
                                        function ($query) use ($search) {
                                            $query->where(
                                                'seat_number',
                                                'like',
                                                '%' . $search . '%'
                                            );
                                        }
                                    );
                            }
                        );
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $availableStudents = Student::whereDoesntHave(
            'seatAssignments',
            function ($query) {
                $query->where('status', 'active');
            }
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.student.index',
            compact(
                'seats',
                'libraries',
                'fees',
                'students',
                'availableStudents'
            )
        );
    }

    public function create()
    {
        return view('admin.student.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'aadhar_no' => [
                'required',
                'digits:12',
                'unique:students,aadhar_no',
            ],
            'biometric_no' => 'nullable|string|max:255',
            'student_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'id_front' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'id_back' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $studentPhoto = $request
            ->file('student_photo')
            ->store('students/photos', 'public');

        $idFront = $request
            ->file('id_front')
            ->store('students/id-proof', 'public');

        $idBack = $request
            ->file('id_back')
            ->store('students/id-proof', 'public');

        Student::create([
            'name' => $data['name'],
            'father' => $data['father'],
            'village' => $data['village'],
            'mobile' => $data['mobile'],
            'aadhar_no' => $data['aadhar_no'],
            'biometric_no' => $data['biometric_no'] ?? null,
            'student_photo' => $studentPhoto,
            'id_front' => $idFront,
            'id_back' => $idBack,
        ]);

        return redirect()
            ->route('admin.student.index')
            ->with(
                'success',
                'Student added successfully.'
            );
    }

    public function edit(Student $student)
    {
        return view(
            'admin.student.edit',
            compact('student')
        );
    }

    public function update(
        Request $request,
        Student $student
    ) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'aadhar_no' => [
                'required',
                'digits:12',
                Rule::unique(
                    'students',
                    'aadhar_no'
                )->ignore($student->id),
            ],
            'biometric_no' => 'nullable|string|max:255',
            'student_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'id_front' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'id_back' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        if ($request->hasFile('student_photo')) {
            $data['student_photo'] = $request
                ->file('student_photo')
                ->store(
                    'students/photos',
                    'public'
                );
        }

        if ($request->hasFile('id_front')) {
            $data['id_front'] = $request
                ->file('id_front')
                ->store(
                    'students/id-proof',
                    'public'
                );
        }

        if ($request->hasFile('id_back')) {
            $data['id_back'] = $request
                ->file('id_back')
                ->store(
                    'students/id-proof',
                    'public'
                );
        }

        $student->update($data);

        return redirect()
            ->route('admin.student.index')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }

    public function destroy(Student $student)
    {
        $activeAssignment = $student
            ->seatAssignments()
            ->where('status', 'active')
            ->exists();

        if ($activeAssignment) {
            return back()->with(
                'error',
                'This student is currently assigned to a seat. Release the seat before deleting the student.'
            );
        }

        $student->delete();

        return redirect()
            ->route('admin.student.index')
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }

    public function checkAadhar(Request $request)
    {
        $aadhar = preg_replace(
            '/\D/',
            '',
            $request->input('aadhar_no', '')
        );

        if (strlen($aadhar) !== 12) {
            return response()->json([
                'exists' => false,
            ]);
        }

        $exists = Student::where(
            'aadhar_no',
            $aadhar
        )->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }
}
