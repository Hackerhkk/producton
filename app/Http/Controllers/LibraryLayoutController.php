<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use App\Models\Library;
use App\Models\LibraryLayout;
use App\Models\LibraryLayoutItem;
use App\Models\Seat;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LibraryLayoutController extends Controller
{
    public function editor(Request $request)
    {
        $libraries = Library::orderBy('name')->get();

        $selectedLibrary = null;
        $seats = collect();
        $layout = null;

        if ($request->filled('library_id')) {
            $selectedLibrary = Library::findOrFail(
                $request->library_id
            );

            $seats = Seat::with([
                'activeAssignment.student',
            ])
                ->where(
                    'library_id',
                    $selectedLibrary->id
                )
                ->orderBy('seat_number')
                ->get();

            $layout = LibraryLayout::with([
                'items' => function ($query) {
                    $query->orderBy('id');
                },
                'items.seat.activeAssignment.student',
            ])
                ->where(
                    'library_id',
                    $selectedLibrary->id
                )
                ->first();
        }

        return view(
            'admin.seat-map.editor',
            compact(
                'libraries',
                'selectedLibrary',
                'seats',
                'layout'
            )
        );
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'library_id' => [
                'required',
                'integer',
                'exists:libraries,id',
            ],

            'width' => [
                'required',
                'numeric',
                'min:500',
                'max:5000',
            ],

            'height' => [
                'required',
                'numeric',
                'min:400',
                'max:5000',
            ],

            'items' => [
                'nullable',
                'array',
            ],

            'items.*.type' => [
                'required',
                'string',
                'in:seat,table,door,wall',
            ],

            'items.*.seat_id' => [
                'nullable',
                'integer',
            ],

            'items.*.x' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.y' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.width' => [
                'required',
                'numeric',
                'min:10',
            ],

            'items.*.height' => [
                'required',
                'numeric',
                'min:10',
            ],

            'items.*.rotation' => [
                'required',
                'numeric',
            ],
        ]);

        $library = Library::findOrFail(
            $data['library_id']
        );

        $items = $data['items'] ?? [];

        $seatIds = [];

        foreach ($items as $index => $item) {
            if ($item['type'] !== 'seat') {
                continue;
            }

            if (empty($item['seat_id'])) {
                throw ValidationException::withMessages([
                    "items.$index.seat_id" =>
                        'A seat item must have a valid seat.',
                ]);
            }

            $seatId = (int) $item['seat_id'];

            if (in_array($seatId, $seatIds, true)) {
                throw ValidationException::withMessages([
                    "items.$index.seat_id" =>
                        'The same seat cannot be placed more than once.',
                ]);
            }

            $seatIds[] = $seatId;
        }

        if (!empty($seatIds)) {
            $validSeatIds = Seat::where(
                'library_id',
                $library->id
            )
                ->whereIn(
                    'id',
                    $seatIds
                )
                ->pluck('id')
                ->map(
                    fn ($id) => (int) $id
                )
                ->all();

            $invalidSeatIds = array_values(
                array_diff(
                    $seatIds,
                    $validSeatIds
                )
            );

            if (!empty($invalidSeatIds)) {
                throw ValidationException::withMessages([
                    'items' =>
                        'One or more selected seats do not belong to this library.',
                ]);
            }
        }

        foreach ($items as $index => $item) {
            $width = (float) $item['width'];
            $height = (float) $item['height'];
            $x = (float) $item['x'];
            $y = (float) $item['y'];

            if ($x + $width > (float) $data['width']) {
                throw ValidationException::withMessages([
                    "items.$index.x" =>
                        'An item cannot extend outside the room width.',
                ]);
            }

            if ($y + $height > (float) $data['height']) {
                throw ValidationException::withMessages([
                    "items.$index.y" =>
                        'An item cannot extend outside the room height.',
                ]);
            }
        }

        DB::transaction(function () use (
            $data,
            $library,
            $items
        ) {
            $layout = LibraryLayout::updateOrCreate(
                [
                    'library_id' => $library->id,
                ],
                [
                    'width' => $data['width'],
                    'height' => $data['height'],
                ]
            );

            $layout->items()->delete();

            foreach ($items as $item) {
                LibraryLayoutItem::create([
                    'library_layout_id' =>
                        $layout->id,

                    'type' =>
                        $item['type'],

                    'seat_id' =>
                        $item['type'] === 'seat'
                            ? ($item['seat_id'] ?? null)
                            : null,

                    'x' =>
                        $item['x'],

                    'y' =>
                        $item['y'],

                    'width' =>
                        $item['width'],

                    'height' =>
                        $item['height'],

                    'rotation' =>
                        $item['rotation'],
                ]);
            }
        });

        return back()->with(
            'success',
            'Library layout saved successfully.'
        );
    }
    public function view(Request $request)
{
$libraries = Library::orderBy('name')->get();

$selectedLibrary = null;
$layout = null;
$availableStudents = collect();
$fees = collect();

if ($request->filled('library_id')) {
    $selectedLibrary = Library::findOrFail(
        $request->library_id
    );

    $layout = LibraryLayout::with([
        'items' => function ($query) {
            $query->orderBy('id');
        },
        'items.seat',
        'items.seat.activeAssignment',
        'items.seat.activeAssignment.student',
        'items.seat.activeAssignment.fees',
    ])
        ->where(
            'library_id',
            $selectedLibrary->id
        )
        ->first();

    $availableStudents = Student::whereDoesntHave(
        'seatAssignments',
        function ($query) {
            $query->where('status', 'active');
        }
    )
        ->orderBy('name')
        ->get();

    $fees = Fees::where(
        'library_id',
        $selectedLibrary->id
    )
        ->where(
            'fees',
            'Monthly'
        )
        ->orderBy('amount')
        ->get();
}

return view(
    'admin.seat-map.view',
    compact(
        'libraries',
        'selectedLibrary',
        'layout',
        'availableStudents',
        'fees'
    )
);

}

}
