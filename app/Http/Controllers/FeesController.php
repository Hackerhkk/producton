<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use App\Models\Library;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    public function index()
    {
        $libraries = Library::orderBy('name')->get();

        $fees = Fees::with('library')
            ->latest()
            ->get();

        return view(
            'admin.fees.index',
            compact(
                'fees',
                'libraries'
            )
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'library_id' => 'required|exists:libraries,id',
            'fees' => 'required|string|max:30',
            'amount' => 'required|numeric|min:0',
        ]);

        Fees::create([
            'library_id' => $data['library_id'],
            'fees' => $data['fees'],
            'amount' => $data['amount'],
        ]);

        return redirect()
            ->route('admin.fees.index')
            ->with(
                'success',
                'Fee plan added successfully.'
            );
    }


    public function destroy(Fees $fees)
    {
        /*
        |--------------------------------------------------------------------------
        | Do not delete fee plan if it has fee records
        |--------------------------------------------------------------------------
        */

        if ($fees->feeCycles()->exists()) {
            return redirect()
                ->route('admin.fees.index')
                ->with(
                    'error',
                    'This fee plan cannot be deleted because it is already used in fee records.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Do not delete fee plan if it is assigned to a student
        |--------------------------------------------------------------------------
        */

        if ($fees->seatAssignments()->exists()) {
            return redirect()
                ->route('admin.fees.index')
                ->with(
                    'error',
                    'This fee plan cannot be deleted because it is assigned to a student.'
                );
        }


        $fees->delete();

        return redirect()
            ->route('admin.fees.index')
            ->with(
                'success',
                'Fee plan deleted successfully.'
            );
    }
}

