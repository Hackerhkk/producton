<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestAnswer;
use App\Models\TestSeries;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentTestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TEST LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Test::with('testSeries')
            ->where('status', true)
            ->whereHas('testSeries', function ($q) {
                $q->where('status', true);
            });


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                );

                $q->orWhereHas(
                    'testSeries',
                    function ($series) use ($search) {

                        $series->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                        $series->orWhere(
                            'subject',
                            'like',
                            "%{$search}%"
                        );
                    }
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | SERIES FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('series')) {

            $query->where(
                'test_series_id',
                $request->series
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TESTS
        |--------------------------------------------------------------------------
        */

        $tests = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | SERIES
        |--------------------------------------------------------------------------
        */

        $series = TestSeries::where(
            'status',
            true
        )
            ->orderBy('name')
            ->get();


        return view(
            'test.index',
            compact(
                'tests',
                'series'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TEST DETAILS
    |--------------------------------------------------------------------------
    */

    public function show(Test $test)
    {
        $test->load('testSeries');


        /*
        |--------------------------------------------------------------------------
        | LEADERBOARD
        |--------------------------------------------------------------------------
        */

        $leaderboard = TestAttempt::with('user')
            ->where(
                'test_id',
                $test->id
            )
            ->where(
                'status',
                'submitted'
            )
            ->orderByDesc('obtained_marks')
            ->orderBy('time_taken')
            ->get();


        $totalTesters =
            $leaderboard->count();


        /*
        |--------------------------------------------------------------------------
        | MY RANK
        |--------------------------------------------------------------------------
        */

        $myRank = null;

        $user = Auth::user();

        if ($user) {

            $myAttempt = $leaderboard
                ->where(
                    'user_id',
                    $user->id
                )
                ->first();

            if ($myAttempt) {

                $myRank =
                    $leaderboard->search(
                        function ($attempt) use ($myAttempt) {

                            return (int) $attempt->id ===
                                (int) $myAttempt->id;
                        }
                    ) + 1;
            }
        }


        return view(
            'test.show',
            compact(
                'test',
                'leaderboard',
                'myRank',
                'totalTesters'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK TEST ACCESS
    |--------------------------------------------------------------------------
    */

    private function hasTestAccess(Test $test): bool
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | TEST FREE
        |--------------------------------------------------------------------------
        */

        if ($test->is_free) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | SERIES FREE
        |--------------------------------------------------------------------------
        */

        $test->loadMissing('testSeries');

        if (
            $test->testSeries &&
            $test->testSeries->is_free
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | TEST ACCESS ENABLED
        |--------------------------------------------------------------------------
        */

        if (!$user->tests_enabled) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = $user
            ->latestSubscription()
            ->with('plan')
            ->first();

        if (!$subscription) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | ACTIVE
        |--------------------------------------------------------------------------
        */

        if (!$subscription->isActive()) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | PLAN ACCESS
        |--------------------------------------------------------------------------
        */

        if (
            !$subscription->plan ||
            !$subscription->plan->tests_access
        ) {
            return false;
        }


        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | GET TEST QUESTION IDS
    |--------------------------------------------------------------------------
    |
    | Sirf isi TEST ke questions.
    |
    | test.total_questions =
    | maximum allowed questions.
    |
    */

    private function getTestQuestionIds(
        Test $test
    ): array {

        $maximumQuestions = max(
            0,
            (int) $test->total_questions
        );


        if ($maximumQuestions <= 0) {
            return [];
        }


        return Question::where(
            'test_id',
            $test->id
        )
            ->orderBy('id')
            ->limit($maximumQuestions)
            ->pluck('id')
            ->map(
                fn ($id) => (int) $id
            )
            ->values()
            ->all();
    }


    /*
    |--------------------------------------------------------------------------
    | GET ATTEMPT QUESTION IDS
    |--------------------------------------------------------------------------
    |
    | Same attempt ke questions ka order
    | permanently preserve hota hai.
    |
    */

    private function getAttemptQuestionIds(
        TestAttempt $attempt
    ): array {

        /*
        |--------------------------------------------------------------------------
        | EXISTING ORDER
        |--------------------------------------------------------------------------
        */

        if (
            is_array($attempt->question_order) &&
            count($attempt->question_order) > 0
        ) {

            return array_map(
                'intval',
                $attempt->question_order
            );
        }


        /*
        |--------------------------------------------------------------------------
        | OLD ATTEMPT
        |--------------------------------------------------------------------------
        */

        $test = $attempt->test;


        $questionIds =
            $this->getTestQuestionIds(
                $test
            );


        if (
            count($questionIds) === 0
        ) {
            return [];
        }


        /*
        |--------------------------------------------------------------------------
        | RANDOMIZE
        |--------------------------------------------------------------------------
        */

        shuffle($questionIds);


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $attempt->update([
            'question_order' =>
                $questionIds,
        ]);


        return array_map(
            'intval',
            $questionIds
        );
    }


    /*
    |--------------------------------------------------------------------------
    | START TEST
    |--------------------------------------------------------------------------
    */

    public function start(Test $test)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | ACTIVE USER
        |--------------------------------------------------------------------------
        */

        if (!$user->is_active) {

            Auth::guard('web')->logout();

            request()
                ->session()
                ->invalidate();

            request()
                ->session()
                ->regenerateToken();


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Your account has been disabled. Please contact the administrator.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | TEST ACCESS ENABLED
        |--------------------------------------------------------------------------
        */

        if (!$user->tests_enabled) {

            return redirect()
                ->route('student.tests.index')
                ->with(
                    'error',
                    'Tests access is disabled for your account.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD SERIES
        |--------------------------------------------------------------------------
        */

        $test->load('testSeries');


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (!$test->status) {

            return back()
                ->with(
                    'error',
                    'This test is currently unavailable.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | START DATE
        |--------------------------------------------------------------------------
        */

        if (
            $test->starts_at &&
            now()->lt($test->starts_at)
        ) {

            return back()
                ->with(
                    'error',
                    'This test has not started yet.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | END DATE
        |--------------------------------------------------------------------------
        */

        if (
            $test->ends_at &&
            now()->gt($test->ends_at)
        ) {

            return back()
                ->with(
                    'error',
                    'This test has already ended.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        if (!$this->hasTestAccess($test)) {

            return redirect()
                ->route('subscription.index')
                ->with(
                    'error',
                    'Please purchase an active test subscription to continue.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | EXISTING ATTEMPT
        |--------------------------------------------------------------------------
        */

        $existingAttempt = TestAttempt::where(
            'test_id',
            $test->id
        )
            ->where(
                'user_id',
                $user->id
            )
            ->where(
                'status',
                'in_progress'
            )
            ->latest('id')
            ->first();


        if ($existingAttempt) {

            return redirect()
                ->route(
                    'student.test.attempt',
                    $existingAttempt
                );
        }


        /*
        |--------------------------------------------------------------------------
        | GET TEST QUESTIONS
        |--------------------------------------------------------------------------
        */

        $questionIds =
            $this->getTestQuestionIds(
                $test
            );


        /*
        |--------------------------------------------------------------------------
        | NO QUESTIONS
        |--------------------------------------------------------------------------
        */

        if (
            count($questionIds) === 0
        ) {

            return back()
                ->with(
                    'error',
                    'This test does not have any questions yet.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | RANDOM ORDER
        |--------------------------------------------------------------------------
        */

        shuffle($questionIds);


        /*
        |--------------------------------------------------------------------------
        | QUESTION COUNT
        |--------------------------------------------------------------------------
        */

        $questionCount =
            count($questionIds);


        /*
        |--------------------------------------------------------------------------
        | CREATE ATTEMPT
        |--------------------------------------------------------------------------
        */

        $attempt = TestAttempt::create([

            'test_id' =>
                $test->id,

            'user_id' =>
                $user->id,

            'question_order' =>
                $questionIds,

            'started_at' =>
                now(),

            'total_questions' =>
                $questionCount,

            'attempted' =>
                0,

            'correct' =>
                0,

            'wrong' =>
                0,

            'skipped' =>
                $questionCount,

            'total_marks' =>
                $test->total_marks,

            'obtained_marks' =>
                0,

            'percentage' =>
                0,

            'passed' =>
                false,

            'status' =>
                'in_progress',

            'time_taken' =>
                0,
        ]);


        return redirect()
            ->route(
                'student.test.attempt',
                $attempt
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ATTEMPT PAGE
    |--------------------------------------------------------------------------
    */

    public function attempt(
        TestAttempt $attempt
    ) {

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        if (
            (int) $attempt->user_id !==
            (int) $user->id
        ) {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | SUBMITTED
        |--------------------------------------------------------------------------
        */

        if (
            $attempt->status !==
            'in_progress'
        ) {

            return redirect()
                ->route(
                    'student.test.result',
                    $attempt
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TEST
        |--------------------------------------------------------------------------
        */

        $test = $attempt->test;

        $test->load('testSeries');


        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        if (!$this->hasTestAccess($test)) {

            return redirect()
                ->route('subscription.index')
                ->with(
                    'error',
                    'You do not have access to this test.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DURATION
        |--------------------------------------------------------------------------
        */

        $durationSeconds = max(
            0,
            ((int) $test->duration) * 60
        );


        /*
        |--------------------------------------------------------------------------
        | ELAPSED
        |--------------------------------------------------------------------------
        */

        $elapsedSeconds = 0;

        if ($attempt->started_at) {

            $elapsedSeconds = max(
                0,
                (int) $attempt->started_at
                    ->diffInSeconds(
                        now(),
                        false
                    )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | REMAINING
        |--------------------------------------------------------------------------
        */

        $remainingSeconds = max(
            0,
            $durationSeconds -
            $elapsedSeconds
        );


        /*
        |--------------------------------------------------------------------------
        | AUTO SUBMIT
        |--------------------------------------------------------------------------
        */

        if (
            $durationSeconds > 0 &&
            $remainingSeconds <= 0
        ) {

            $this->finalizeAttempt(
                $attempt
            );


            return redirect()
                ->route(
                    'student.test.result',
                    $attempt
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ATTEMPT QUESTION ORDER
        |--------------------------------------------------------------------------
        */

        $questionIds =
            $this->getAttemptQuestionIds(
                $attempt
            );


        $questionCount =
            count($questionIds);


        /*
        |--------------------------------------------------------------------------
        | NO QUESTIONS
        |--------------------------------------------------------------------------
        */

        if ($questionCount <= 0) {

            return back()
                ->with(
                    'error',
                    'This test does not have any questions yet.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FIRST QUESTION
        |--------------------------------------------------------------------------
        */

        $firstQuestionId =
            $questionIds[0];


        $question = Question::where(
            'test_id',
            $test->id
        )
            ->where(
                'id',
                $firstQuestionId
            )
            ->first();


        if (!$question) {

            return back()
                ->with(
                    'error',
                    'No questions are available for this test.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'test.attempt',
            [
                'attempt' =>
                    $attempt,

                'test' =>
                    $test,

                'question' =>
                    $question,

                'questionCount' =>
                    $questionCount,

                'totalQuestions' =>
                    $questionCount,

                'remainingSeconds' =>
                    $remainingSeconds,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD QUESTION
    |--------------------------------------------------------------------------
    */

    public function question(
        TestAttempt $attempt,
        int $number
    ) {

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return response()->json([
                'message' =>
                    'Unauthenticated.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        if (
            (int) $attempt->user_id !==
            (int) $user->id
        ) {

            return response()->json([
                'message' =>
                    'Unauthorized.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $attempt->status !==
            'in_progress'
        ) {

            return response()->json([
                'message' =>
                    'Test already submitted.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | TEST
        |--------------------------------------------------------------------------
        */

        $test = $attempt->test;


        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        if (!$this->hasTestAccess($test)) {

            return response()->json([
                'message' =>
                    'Test access denied.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | ATTEMPT ORDER
        |--------------------------------------------------------------------------
        */

        $questionIds =
            $this->getAttemptQuestionIds(
                $attempt
            );


        $questionCount =
            count($questionIds);


        /*
        |--------------------------------------------------------------------------
        | NUMBER
        |--------------------------------------------------------------------------
        */

        if (
            $number < 1 ||
            $number > $questionCount
        ) {

            return response()->json([
                'message' =>
                    'Invalid question number.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | QUESTION ID
        |--------------------------------------------------------------------------
        */

        $questionId =
            (int) $questionIds[
                $number - 1
            ];


        /*
        |--------------------------------------------------------------------------
        | QUESTION
        |--------------------------------------------------------------------------
        */

        $question = Question::select([
            'id',
            'test_id',
            'question',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'marks',
        ])
            ->where(
                'test_id',
                $test->id
            )
            ->where(
                'id',
                $questionId
            )
            ->first();


        if (!$question) {

            return response()->json([
                'message' =>
                    'Question not found.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | SAVED ANSWER
        |--------------------------------------------------------------------------
        */

        $answer = TestAnswer::select([
            'question_id',
            'selected_answer',
        ])
            ->where(
                'test_attempt_id',
                $attempt->id
            )
            ->where(
                'question_id',
                $question->id
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'id' =>
                $question->id,

            'number' =>
                $number,

            'total' =>
                $questionCount,

            'question' =>
                $question->question,

            'option_a' =>
                $question->option_a,

            'option_b' =>
                $question->option_b,

            'option_c' =>
                $question->option_c,

            'option_d' =>
                $question->option_d,

            'marks' =>
                (float) $question->marks,

            'selected_answer' =>
                $answer?->selected_answer,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE ANSWER
    |--------------------------------------------------------------------------
    */

    public function saveAnswer(
        Request $request,
        TestAttempt $attempt
    ) {

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return response()->json([
                'message' =>
                    'Unauthenticated.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        if (
            (int) $attempt->user_id !==
            (int) $user->id
        ) {

            return response()->json([
                'message' =>
                    'Unauthorized.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $attempt->status !==
            'in_progress'
        ) {

            return response()->json([
                'message' =>
                    'Test already submitted.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'question_id' => [
                'required',
                'integer',
            ],

            'selected_answer' => [
                'required',
                'in:A,B,C,D',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | TEST
        |--------------------------------------------------------------------------
        */

        $test = $attempt->test;


        /*
        |--------------------------------------------------------------------------
        | ATTEMPT QUESTIONS
        |--------------------------------------------------------------------------
        */

        $questionIds =
            $this->getAttemptQuestionIds(
                $attempt
            );


        $questionId =
            (int) $validated['question_id'];


        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $questionId,
                $questionIds,
                true
            )
        ) {

            return response()->json([
                'message' =>
                    'Invalid question for this attempt.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | QUESTION
        |--------------------------------------------------------------------------
        */

        $question = Question::select([
            'id',
            'test_id',
            'correct_answer',
            'marks',
        ])
            ->where(
                'test_id',
                $test->id
            )
            ->where(
                'id',
                $questionId
            )
            ->first();


        if (!$question) {

            return response()->json([
                'message' =>
                    'Invalid question.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | SELECTED ANSWER
        |--------------------------------------------------------------------------
        */

        $selectedAnswer =
            strtoupper(
                $validated['selected_answer']
            );


        /*
        |--------------------------------------------------------------------------
        | CORRECT
        |--------------------------------------------------------------------------
        */

        $isCorrect =
            $selectedAnswer ===
            strtoupper(
                $question->correct_answer
            );


        /*
        |--------------------------------------------------------------------------
        | MARKS
        |--------------------------------------------------------------------------
        */

        $marks =
            (float) $question->marks;


        /*
        |--------------------------------------------------------------------------
        | OBTAINED MARKS
        |--------------------------------------------------------------------------
        */

        $obtainedMarks = 0;


        if ($isCorrect) {

            $obtainedMarks =
                $marks;

        } elseif (
            $test->negative_marking
        ) {

            $obtainedMarks =
                -(
                    (float)
                    $test->negative_marks
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE ANSWER
        |--------------------------------------------------------------------------
        */

        TestAnswer::updateOrCreate(

            [

                'test_attempt_id' =>
                    $attempt->id,

                'question_id' =>
                    $question->id,
            ],

            [

                'selected_answer' =>
                    $selectedAnswer,

                'is_correct' =>
                    $isCorrect,

                'marks_obtained' =>
                    $obtainedMarks,
            ]
        );


        return response()->json([

            'success' =>
                true,

            'is_correct' =>
                $isCorrect,

            'marks_obtained' =>
                $obtainedMarks,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT TEST
    |--------------------------------------------------------------------------
    */

    public function submit(
        TestAttempt $attempt
    ) {

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        if (
            (int) $attempt->user_id !==
            (int) $user->id
        ) {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | ALREADY SUBMITTED
        |--------------------------------------------------------------------------
        */

        if (
            $attempt->status !==
            'in_progress'
        ) {

            return redirect()
                ->route(
                    'student.test.result',
                    $attempt
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FINALIZE
        |--------------------------------------------------------------------------
        */

        $this->finalizeAttempt(
            $attempt
        );


        return redirect()
            ->route(
                'student.test.result',
                $attempt
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FINALIZE ATTEMPT - OPTIMIZED
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | 1000 questions ke submit par:
    |
    | OLD METHOD:
    |   - 1000 questions load
    |   - PHP foreach
    |   - question lookup
    |   - answer lookup
    |
    | NEW METHOD:
    |   - questions table load nahi hoti
    |   - TestAnswer par aggregate queries
    |   - direct score calculation
    |
    */

private function finalizeAttempt(
    TestAttempt $attempt
): void {

    /*
    |--------------------------------------------------------------------------
    | ALREADY SUBMITTED
    |--------------------------------------------------------------------------
    */

    if ($attempt->status === 'submitted') {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | TEST
    |--------------------------------------------------------------------------
    */

    $test = $attempt->test;


    /*
    |--------------------------------------------------------------------------
    | ATTEMPT QUESTION IDS
    |--------------------------------------------------------------------------
    */

    $questionIds = $this->getAttemptQuestionIds($attempt);

    $totalQuestions = count($questionIds);


    /*
    |--------------------------------------------------------------------------
    | ANSWERS
    |--------------------------------------------------------------------------
    */

    $answers = TestAnswer::where(
        'test_attempt_id',
        $attempt->id
    )->get();


    /*
    |--------------------------------------------------------------------------
    | ATTEMPTED
    |--------------------------------------------------------------------------
    */

    $attempted = $answers->count();


    /*
    |--------------------------------------------------------------------------
    | LOAD QUESTIONS IN ONE QUERY
    |--------------------------------------------------------------------------
    |
    | 1000 separate queries nahi chalengi.
    | Sirf ek query me required questions load honge.
    |
    */

    $questions = Question::where(
        'test_id',
        $test->id
    )
        ->whereIn(
            'id',
            $questionIds
        )
        ->get()
        ->keyBy('id');


    /*
    |--------------------------------------------------------------------------
    | CALCULATE RESULT
    |--------------------------------------------------------------------------
    */

    $correct = 0;

    $wrong = 0;

    $obtainedMarks = 0;


    foreach ($answers as $answer) {

        $question = $questions->get(
            $answer->question_id
        );


        /*
        |--------------------------------------------------------------------------
        | QUESTION NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$question) {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK ANSWER
        |--------------------------------------------------------------------------
        */

        $isCorrect =
            strtoupper(
                trim(
                    (string) $answer->selected_answer
                )
            ) ===
            strtoupper(
                trim(
                    (string) $question->correct_answer
                )
            );


        /*
        |--------------------------------------------------------------------------
        | CORRECT
        |--------------------------------------------------------------------------
        */

        if ($isCorrect) {

            $correct++;

            $obtainedMarks +=
                (float) $question->marks;

            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | WRONG
        |--------------------------------------------------------------------------
        */

        $wrong++;


        /*
        |--------------------------------------------------------------------------
        | NEGATIVE MARKING
        |--------------------------------------------------------------------------
        */

        if ($test->negative_marking) {

            $obtainedMarks -=
                (float) $test->negative_marks;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SKIPPED
    |--------------------------------------------------------------------------
    */

    $skipped = max(
        0,
        $totalQuestions - $attempted
    );


    /*
    |--------------------------------------------------------------------------
    | SCORE CANNOT BE NEGATIVE
    |--------------------------------------------------------------------------
    */

    $obtainedMarks = max(
        0,
        $obtainedMarks
    );


    /*
    |--------------------------------------------------------------------------
    | TOTAL MARKS
    |--------------------------------------------------------------------------
    */

    $totalMarks =
        (float) $test->total_marks;


    /*
    |--------------------------------------------------------------------------
    | PERCENTAGE
    |--------------------------------------------------------------------------
    */

    $percentage = 0;


    if ($totalMarks > 0) {

        $percentage = round(
            (
                $obtainedMarks /
                $totalMarks
            ) * 100,
            2
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LIMIT PERCENTAGE
    |--------------------------------------------------------------------------
    */

    $percentage = min(
        100,
        max(
            0,
            $percentage
        )
    );


    /*
    |--------------------------------------------------------------------------
    | PASS / FAIL
    |--------------------------------------------------------------------------
    */

    $passed =
        $obtainedMarks >=
        (float) $test->passing_marks;


    /*
    |--------------------------------------------------------------------------
    | TIME TAKEN
    |--------------------------------------------------------------------------
    */

    $timeTaken = 0;


    if ($attempt->started_at) {

        $timeTaken = max(
            0,
            (int) $attempt->started_at
                ->diffInSeconds(
                    now(),
                    false
                )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MAX DURATION
    |--------------------------------------------------------------------------
    */

    $maxDurationSeconds = max(
        0,
        ((int) $test->duration) * 60
    );


    /*
    |--------------------------------------------------------------------------
    | LIMIT TIME
    |--------------------------------------------------------------------------
    */

    if ($maxDurationSeconds > 0) {

        $timeTaken = min(
            $timeTaken,
            $maxDurationSeconds
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FINAL UPDATE
    |--------------------------------------------------------------------------
    */

    $attempt->update([

        'submitted_at' =>
            now(),

        'attempted' =>
            $attempted,

        'correct' =>
            $correct,

        'wrong' =>
            $wrong,

        'skipped' =>
            $skipped,

        'total_questions' =>
            $totalQuestions,

        'total_marks' =>
            $totalMarks,

        'obtained_marks' =>
            $obtainedMarks,

        'percentage' =>
            $percentage,

        'passed' =>
            $passed,

        'status' =>
            'submitted',

        'time_taken' =>
            $timeTaken,
    ]);
}


public function result(
    TestAttempt $attempt
) {

    $user = Auth::user();


    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */

    if (!$user) {

        return redirect()
            ->route('login');
    }


    /*
    |--------------------------------------------------------------------------
    | OWNER CHECK
    |--------------------------------------------------------------------------
    */

    if (
        (int) $attempt->user_id !==
        (int) $user->id
    ) {

        abort(403);
    }


    /*
    |--------------------------------------------------------------------------
    | ONLY SUBMITTED ATTEMPT
    |--------------------------------------------------------------------------
    */

    if (
        $attempt->status !==
        'submitted'
    ) {

        return redirect()
            ->route(
                'student.test.attempt',
                $attempt
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD TEST
    |--------------------------------------------------------------------------
    */

    $attempt->load([
        'test.testSeries',
    ]);


    $test = $attempt->test;


    /*
    |--------------------------------------------------------------------------
    | GET ORIGINAL QUESTION ORDER
    |--------------------------------------------------------------------------
    */

    $questionIds =
        $this->getAttemptQuestionIds(
            $attempt
        );


    /*
    |--------------------------------------------------------------------------
    | LOAD QUESTIONS IN ONE QUERY
    |--------------------------------------------------------------------------
    |
    | 1000 questions = 1 database query
    |
    */

    $questionsById =
        Question::where(
            'test_id',
            $test->id
        )
            ->whereIn(
                'id',
                $questionIds
            )
            ->get()
            ->keyBy('id');


    /*
    |--------------------------------------------------------------------------
    | RESTORE ATTEMPT ORDER
    |--------------------------------------------------------------------------
    */

    $questions = collect();


    foreach (
        $questionIds as $questionId
    ) {

        if (
            isset(
                $questionsById[$questionId]
            )
        ) {

            $questions->push(
                $questionsById[$questionId]
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD ANSWERS
    |--------------------------------------------------------------------------
    |
    | Answers ko question_id se key kar rahe hain.
    |
    */

    $answers =
        TestAnswer::where(
            'test_attempt_id',
            $attempt->id
        )
            ->get()
            ->keyBy(
                'question_id'
            );


    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'test.result',
        compact(
            'attempt',
            'test',
            'questions',
            'answers'
        )
    );
}



}
