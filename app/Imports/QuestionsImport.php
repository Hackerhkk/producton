<?php

namespace App\Imports;

use App\Models\Test;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading
{
    protected Test $test;

    protected int $remainingCapacity;

    public int $imported = 0;

    public array $errors = [];

    public array $remainingRows = [];

    protected int $nextSortOrder;

    public function __construct(
        Test $test,
        int $remainingCapacity
    ) {
        $this->test = $test;

        $this->remainingCapacity =
            $remainingCapacity;

        $this->nextSortOrder =
            ((int) $test->questions()->max('sort_order')) + 1;
    }


    public function collection(Collection $rows)
    {
        $insertRows = [];

        foreach ($rows as $index => $row) {

            /*
            |--------------------------------------------------------------------------
            | If Test Capacity Is Full
            |--------------------------------------------------------------------------
            */

            if (
                $this->imported +
                count($insertRows)
                >= $this->remainingCapacity
            ) {

                $this->remainingRows[] =
                    $this->cleanRow($row);

                continue;
            }


            $question = trim(
                (string) ($row['question'] ?? '')
            );

            $optionA = trim(
                (string) ($row['option_a'] ?? '')
            );

            $optionB = trim(
                (string) ($row['option_b'] ?? '')
            );

            $optionC = trim(
                (string) ($row['option_c'] ?? '')
            );

            $optionD = trim(
                (string) ($row['option_d'] ?? '')
            );

            $correctAnswer = strtoupper(
                trim(
                    (string) (
                        $row['correct_answer'] ?? ''
                    )
                )
            );

            $marks =
                $row['marks'] ?? null;

            $explanation = trim(
                (string) (
                    $row['explanation'] ?? ''
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Skip Completely Empty Rows
            |--------------------------------------------------------------------------
            */

            if (
                $question === '' &&
                $optionA === '' &&
                $optionB === '' &&
                $optionC === '' &&
                $optionD === '' &&
                $correctAnswer === '' &&
                ($marks === null || $marks === '')
            ) {
                continue;
            }


            $excelRow =
                $this->imported +
                count($insertRows) +
                2;


            /*
            |--------------------------------------------------------------------------
            | Validate Question
            |--------------------------------------------------------------------------
            */

            if (
                $question === '' ||
                $optionA === '' ||
                $optionB === '' ||
                $optionC === '' ||
                $optionD === ''
            ) {

                $this->errors[] =
                    "Excel row {$excelRow}: Question and all four options are required.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Validate Correct Answer
            |--------------------------------------------------------------------------
            */

            if (
                !in_array(
                    $correctAnswer,
                    ['A', 'B', 'C', 'D'],
                    true
                )
            ) {

                $this->errors[] =
                    "Excel row {$excelRow}: correct_answer must be A, B, C or D.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Validate Marks
            |--------------------------------------------------------------------------
            */

            if (
                $marks === null ||
                $marks === '' ||
                !is_numeric($marks)
            ) {

                $this->errors[] =
                    "Excel row {$excelRow}: marks must be a valid number.";

                continue;
            }


            if ((float) $marks < 0) {

                $this->errors[] =
                    "Excel row {$excelRow}: marks cannot be negative.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Prepare Insert
            |--------------------------------------------------------------------------
            */

            $insertRows[] = [
                'test_id' => $this->test->id,

                'question' => $question,

                'option_a' => $optionA,

                'option_b' => $optionB,

                'option_c' => $optionC,

                'option_d' => $optionD,

                'correct_answer' => $correctAnswer,

                'marks' => $marks,

                'explanation' =>
                    $explanation !== ''
                        ? $explanation
                        : null,

                'sort_order' =>
                    $this->nextSortOrder++,

                'created_at' => now(),

                'updated_at' => now(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Batch Insert
        |--------------------------------------------------------------------------
        */

        if (!empty($insertRows)) {

            DB::table('questions')
                ->insert($insertRows);

            $this->imported +=
                count($insertRows);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Clean Remaining Excel Row
    |--------------------------------------------------------------------------
    */

    protected function cleanRow($row): array
    {
        return [
            'question' =>
                $row['question'] ?? '',

            'option_a' =>
                $row['option_a'] ?? '',

            'option_b' =>
                $row['option_b'] ?? '',

            'option_c' =>
                $row['option_c'] ?? '',

            'option_d' =>
                $row['option_d'] ?? '',

            'correct_answer' =>
                $row['correct_answer'] ?? '',

            'marks' =>
                $row['marks'] ?? '',

            'explanation' =>
                $row['explanation'] ?? '',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Chunk Size
    |--------------------------------------------------------------------------
    */

    public function chunkSize(): int
    {
        return 100;
    }
}
