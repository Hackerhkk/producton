<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestTopperController extends Controller
{
    public function index(Request $request): View
    {
        $tests = Test::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $selectedTestId = $request->integer('test_id');

        $query = TestAttempt::query()
            ->with([
                'user',
                'test',
                'test.testSeries',
            ])
            ->where('status', 'submitted')
            ->whereNotNull('user_id');

        if ($selectedTestId) {
            $query->where(
                'test_id',
                $selectedTestId
            );
        }

        /*
         * Highest score first.
         * If marks are equal, higher percentage first.
         * If still equal, faster time first.
         */
        $attempts = $query
            ->orderByDesc('obtained_marks')
            ->orderByDesc('percentage')
            ->orderBy('time_taken')
            ->get();

        /*
         * For each user + test combination,
         * keep only their best attempt.
         */
        $bestAttempts = $attempts
            ->groupBy(function ($attempt) {
                return $attempt->test_id . '-' . $attempt->user_id;
            })
            ->map(function ($group) {
                return $group->first();
            })
            ->sortBy([
                ['obtained_marks', 'desc'],
                ['percentage', 'desc'],
                ['time_taken', 'asc'],
            ])
            ->values();

        /*
         * Rank the final list.
         */
        $toppers = $bestAttempts
            ->map(function ($attempt, $index) {

                $attempt->rank =
                    $index + 1;

                return $attempt;
            });

        return view(
            'test-toppers',
            compact(
                'tests',
                'toppers',
                'selectedTestId'
            )
        );
    }
}
