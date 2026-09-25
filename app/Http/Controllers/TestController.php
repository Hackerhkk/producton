<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestSeries;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Show tests of a test series.
     */
    public function index(TestSeries $testSeries)
    {
        $tests = $testSeries->tests()
            ->latest()
            ->paginate(12);

        return view(
            'admin.test-series.tests.index',
            compact('testSeries', 'tests')
        );
    }

    /**
     * Store a new test.
     */
    public function store(
        Request $request,
        TestSeries $testSeries
    ) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'duration' => [
                'required',
                'integer',
                'min:1',
                'max:600',
            ],

            'total_questions' => [
                'required',
                'integer',
                'min:0',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'passing_marks' => [
                'required',
                'numeric',
                'min:0',
                'lte:total_marks',
            ],

            'negative_marking' => [
                'nullable',
                'boolean',
            ],

            'negative_marks' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'is_free' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Test
        |--------------------------------------------------------------------------
        | Direct assignment is intentionally used here instead of
        | $testSeries->tests()->create() so the submitted values are
        | stored exactly as received.
        */

        $test = new Test();

        $test->test_series_id = $testSeries->id;

        $test->name = $request->input('name');

        $test->duration = (int) $request->input('duration');

        $test->total_questions = (int) $request->input('total_questions');

        $test->total_marks = (float) $request->input('total_marks');

        $test->passing_marks = (float) $request->input('passing_marks');

        $test->negative_marking =
            $request->boolean('negative_marking');

        $test->negative_marks =
            (float) ($request->input('negative_marks') ?? 0);

        $test->starts_at = $request->input('starts_at');

        $test->ends_at = $request->input('ends_at');

        $test->status = true;

        $test->is_free =
            $request->boolean('is_free');

        $test->save();

        return back()->with(
            'success',
            'Test created successfully.'
        );
    }

    /**
     * Update an existing test.
     */
    public function update(
        Request $request,
        Test $test
    ) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'duration' => [
                'required',
                'integer',
                'min:1',
                'max:600',
            ],

            'total_questions' => [
                'required',
                'integer',
                'min:0',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'passing_marks' => [
                'required',
                'numeric',
                'min:0',
                'lte:total_marks',
            ],

            'negative_marking' => [
                'nullable',
                'boolean',
            ],

            'negative_marks' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'is_free' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Test
        |--------------------------------------------------------------------------
        */

        $test->name =
            $request->input('name');

        $test->duration =
            (int) $request->input('duration');

        $test->total_questions =
            (int) $request->input('total_questions');

        $test->total_marks =
            (float) $request->input('total_marks');

        $test->passing_marks =
            (float) $request->input('passing_marks');

        $test->negative_marking =
            $request->boolean('negative_marking');

        $test->negative_marks =
            (float) ($request->input('negative_marks') ?? 0);

        $test->starts_at =
            $request->input('starts_at');

        $test->ends_at =
            $request->input('ends_at');

        $test->is_free =
            $request->boolean('is_free');

        $test->save();

        return back()->with(
            'success',
            'Test updated successfully.'
        );
    }

    /**
     * Toggle test status.
     */
    public function toggleStatus(Test $test)
    {
        $test->update([
            'status' => !$test->status,
        ]);

        return back()->with(
            'success',
            'Test status updated successfully.'
        );
    }

    /**
     * Delete test.
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return back()->with(
            'success',
            'Test deleted successfully.'
        );
    }
}
