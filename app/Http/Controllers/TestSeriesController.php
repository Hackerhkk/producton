<?php

namespace App\Http\Controllers;

use App\Models\TestSeries;
use Illuminate\Http\Request;

class TestSeriesController extends Controller
{
    public function index()
    {
        $testSeries = TestSeries::withCount('tests')
            ->latest()
            ->paginate(12);

        return view(
            'admin.test-series.index',
            compact('testSeries')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_free' => [
                'nullable',
                'boolean',
            ],
        ]);

        TestSeries::create([
            'name' => $request->name,
            'description' => $request->description,
            'subject' => $request->subject,
            'status' => true,
            'is_free' => $request->boolean('is_free'),
        ]);

        return back()->with(
            'success',
            'Test series created successfully.'
        );
    }

    public function update(
        Request $request,
        TestSeries $testSeries
    ) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_free' => [
                'nullable',
                'boolean',
            ],
        ]);

        $testSeries->update([
            'name' => $request->name,
            'description' => $request->description,
            'subject' => $request->subject,
            'is_free' => $request->boolean('is_free'),
        ]);

        return back()->with(
            'success',
            'Test series updated successfully.'
        );
    }

    public function toggleStatus(
        TestSeries $testSeries
    ) {
        $testSeries->update([
            'status' => !$testSeries->status,
        ]);

        return back()->with(
            'success',
            'Status updated successfully.'
        );
    }

    public function destroy(
        TestSeries $testSeries
    ) {
        $testSeries->delete();

        return back()->with(
            'success',
            'Test series deleted successfully.'
        );
    }
}
