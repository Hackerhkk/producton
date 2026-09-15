<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::latest()->get();

        return view('admin.library.index', compact('libraries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:libraries,name',
            'location' => 'required',
        ]);

        Library::create($data);

        return redirect()
            ->back()
            ->with('success', 'Library added successfully.');
    }

    public function destroy(Library $library)
    {
        $library->delete();

        return redirect()
            ->route('admin.library.index')
            ->with('success', 'Library deleted successfully.');
    }
}