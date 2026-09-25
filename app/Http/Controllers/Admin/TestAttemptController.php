<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestAttempt;
use App\Models\Test;
use App\Models\Student;
use Illuminate\Http\Request;

class TestAttemptController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Result List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = TestAttempt::with([
            'user',
            'test.testSeries',
        ])
            ->where('status', 'submitted')
            ->latest('submitted_at');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Test Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('test_id')) {

            $query->where(
                'test_id',
                $request->test_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Result Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('result')) {

            if ($request->result === 'passed') {

                $query->where('passed', true);

            } elseif ($request->result === 'failed') {

                $query->where('passed', false);
            }
        }

        $attempts = $query
            ->paginate(15)
            ->withQueryString();

        $tests = Test::with('testSeries')
            ->latest()
            ->get();

        return view(
            'admin.test-results.index',
            compact(
                'attempts',
                'tests'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Result Details
    |--------------------------------------------------------------------------
    */

    public function show(TestAttempt $attempt)
    {
        $attempt->load([
            'user',
            'test.testSeries',
            'test.questions',
            'answers.question',
        ]);

        return view(
            'admin.test-results.show',
            compact('attempt')
        );
    }
}
