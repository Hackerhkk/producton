<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
   public function index()
{
    // Libraries for dropdown
    $libraries = \App\Models\Library::orderBy('name')->get();

    // Students
    $students = Student::with([
        'wallet',

        'seatAssignments' => function ($query) {
            $query->where('status', 'active')
                  ->with('seat.library');
        }
    ])

    // Library filter
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

    // Search by Student Name or Seat Number
    ->when(request('search'), function ($query) {

        $search = request('search');

        $query->where(function ($query) use ($search) {

            // Student name
            $query->where('name', 'like', '%' . $search . '%')

                // OR Seat number
                ->orWhereHas('seatAssignments', function ($query) use ($search) {

                    $query->where('status', 'active')
                          ->whereHas('seat', function ($query) use ($search) {
                              $query->where(
                                  'seat_number',
                                  'like',
                                  '%' . $search . '%'
                              );
                          });

                });

        });

    })

    ->latest()
    ->paginate(12)
    ->withQueryString();

    return view(
        'admin.student.index',
        compact('students', 'libraries')
    );
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'required|string|max:255',
            'village' => 'required|string|max:255',

            'mobile' => 'required|digits:10',

            'aadhar_no' => 'required|digits:12',

            'biometric_no' => 'nullable|string|max:255',

            'student_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'id_front' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'id_back' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        // Student Photo
        $studentPhoto = $request->file('student_photo')
            ->store('students/photos', 'public');


        // ID Front Photo
        $idFront = $request->file('id_front')
            ->store('students/id-proof', 'public');


        // ID Back Photo
        $idBack = $request->file('id_back')
            ->store('students/id-proof', 'public');


        // Create Student
        Student::create([
            'name' => $request->name,
            'father' => $request->father,
            'village' => $request->village,
            'mobile' => $request->mobile,

            'aadhar_no' => $request->aadhar_no,
            'biometric_no' => $request->biometric_no,

            'student_photo' => $studentPhoto,
            'id_front' => $idFront,
            'id_back' => $idBack,
        ]);


        return redirect()
            ->route('admin.students')
            ->with('success', 'Student added successfully.');
    }
    public function edit(Student $student)
{
    return view('admin.student.edit', compact('student'));
}
public function update(Request $request, Student $student)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'father' => 'required|string|max:255',
        'village' => 'required|string|max:255',
        'mobile' => 'required|digits:10',
        'aadhar_no' => 'required|digits:12',
        'biometric_no' => 'nullable|string|max:255',

        'student_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'id_front' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        'id_back' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    if ($request->hasFile('student_photo')) {
        $data['student_photo'] =
            $request->file('student_photo')->store('students', 'public');
    }

    if ($request->hasFile('id_front')) {
        $data['id_front'] =
            $request->file('id_front')->store('student-documents', 'public');
    }

    if ($request->hasFile('id_back')) {
        $data['id_back'] =
            $request->file('id_back')->store('student-documents', 'public');
    }

    $student->update($data);

    return redirect()
        ->route('admin.student.index')
        ->with('success', 'Student updated successfully.');
}
public function destroy(Student $student)
{
    $activeAssignment = $student->seatAssignments()
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
        ->with('success', 'Student deleted successfully.');
}
}