<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_answers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('test_attempt_id')
                ->constrained('test_attempts')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnDelete();

            $table->string('selected_answer')
                ->nullable();

            $table->string('correct_answer')
                ->nullable();

            $table->decimal('marks', 8, 2)
                ->default(0);

            $table->decimal('obtained_marks', 8, 2)
                ->default(0);

            $table->boolean('is_correct')
                ->default(false);

            $table->boolean('is_attempted')
                ->default(false);

            $table->timestamps();

            $table->unique([
                'test_attempt_id',
                'question_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_answers');
    }
};
