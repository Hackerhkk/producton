<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportQuestionsRequest;
use App\Imports\QuestionsImport;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    public function index(Test $test)
    {
        $test->load('testSeries');

        $questions = $test->questions()
            ->paginate(15);

        return view(
            'admin.test-series.questions.index',
            compact('test', 'questions')
        );
    }

    public function store(
        Request $request,
        Test $test
    ) {
        $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string'],
            'option_b' => ['required', 'string'],
            'option_c' => ['required', 'string'],
            'option_d' => ['required', 'string'],
            'correct_answer' => ['required', 'in:A,B,C,D'],
            'marks' => ['required', 'numeric', 'min:0'],
            'explanation' => ['nullable', 'string'],
        ]);

        $currentQuestions = $test->questions()->count();

        if ($currentQuestions >= (int) $test->total_questions) {
            return back()->with(
                'error',
                'Question limit reached. This test allows only ' .
                $test->total_questions .
                ' questions.'
            );
        }

        $test->questions()->create([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'marks' => $request->marks,
            'explanation' => $request->explanation,
            'sort_order' =>
                ((int) $test->questions()->max('sort_order')) + 1,
        ]);

        return back()->with(
            'success',
            'Question added successfully.'
        );
    }

    public function update(
        Request $request,
        Question $question
    ) {
        $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string'],
            'option_b' => ['required', 'string'],
            'option_c' => ['required', 'string'],
            'option_d' => ['required', 'string'],
            'correct_answer' => ['required', 'in:A,B,C,D'],
            'marks' => ['required', 'numeric', 'min:0'],
            'explanation' => ['nullable', 'string'],
        ]);

        $question->update([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'marks' => $request->marks,
            'explanation' => $request->explanation,
        ]);

        return back()->with(
            'success',
            'Question updated successfully.'
        );
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with(
            'success',
            'Question deleted successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Download Excel Template
    |--------------------------------------------------------------------------
    */

    public function downloadTemplate(Test $test)
    {
        return Excel::download(
            new class implements FromArray {

                public function array(): array
                {
                    return [
                        [
                            'question',
                            'option_a',
                            'option_b',
                            'option_c',
                            'option_d',
                            'correct_answer',
                            'marks',
                            'explanation',
                        ],
                    ];
                }
            },
            'questions-template.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Import Questions
    |--------------------------------------------------------------------------
    */

    public function import(
        ImportQuestionsRequest $request,
        Test $test
    ) {
        $currentQuestions = $test->questions()->count();

        $questionLimit = (int) $test->total_questions;

        $remainingCapacity = max(
            0,
            $questionLimit - $currentQuestions
        );

        if ($remainingCapacity <= 0) {
            return back()->with(
                'error',
                'Question limit reached. This test already has ' .
                $currentQuestions .
                ' questions out of ' .
                $questionLimit .
                '.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Import
        |--------------------------------------------------------------------------
        */

        $import = new QuestionsImport(
            $test,
            $remainingCapacity
        );

        Excel::import(
            $import,
            $request->file('file')
        );

        $imported = $import->imported;

        $remainingRows = $import->remainingRows;

        $remainingCount = count($remainingRows);

        /*
        |--------------------------------------------------------------------------
        | No valid questions
        |--------------------------------------------------------------------------
        */

        if ($imported === 0) {

            return back()
                ->with(
                    'error',
                    'No valid questions were imported.'
                )
                ->with(
                    'import_errors',
                    $import->errors
                );
        }

        /*
        |--------------------------------------------------------------------------
        | No remaining questions
        |--------------------------------------------------------------------------
        */

        if ($remainingCount === 0) {

            return back()->with(
                'success',
                $imported .
                ' questions imported successfully.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Remaining Excel
        |--------------------------------------------------------------------------
        */

        $fileName =
            'remaining-questions-' .
            $test->id .
            '-' .
            time() .
            '.xlsx';

        $relativePath =
            'imports/' . $fileName;

        Excel::store(
            new class($remainingRows) implements FromArray {

                protected array $rows;

                public function __construct(
                    array $rows
                ) {
                    $this->rows = $rows;
                }

                public function array(): array
                {
                    return array_merge(
                        [
                            [
                                'question',
                                'option_a',
                                'option_b',
                                'option_c',
                                'option_d',
                                'correct_answer',
                                'marks',
                                'explanation',
                            ],
                        ],
                        $this->rows
                    );
                }
            },
            $relativePath,
            'local'
        );

        /*
        |--------------------------------------------------------------------------
        | Check File
        |--------------------------------------------------------------------------
        */

        if (!Storage::disk('local')->exists($relativePath)) {

            return back()->with(
                'success',
                $imported .
                ' questions imported successfully, but the remaining Excel file could not be generated.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Download Remaining Excel Automatically
        |--------------------------------------------------------------------------
        */

        $downloadPath =
            Storage::disk('local')->path($relativePath);

        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'success',
            $imported .
            ' questions imported successfully. ' .
            $remainingCount .
            ' remaining questions are being downloaded.'
        );

        /*
        |--------------------------------------------------------------------------
        | Return Download Response
        |--------------------------------------------------------------------------
        */

        return response()->download(
            $downloadPath,
            $fileName,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }
}
