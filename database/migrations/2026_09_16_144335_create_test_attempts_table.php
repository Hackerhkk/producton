<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_attempts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('test_id')
                ->constrained('tests')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->dateTime('started_at');

            $table->dateTime('submitted_at')
                ->nullable();

            $table->unsignedInteger('total_questions')
                ->default(0);

            $table->unsignedInteger('attempted')
                ->default(0);

            $table->unsignedInteger('correct')
                ->default(0);

            $table->unsignedInteger('wrong')
                ->default(0);

            $table->unsignedInteger('skipped')
                ->default(0);

            $table->decimal('total_marks', 8, 2)
                ->default(0);

            $table->decimal('obtained_marks', 8, 2)
                ->default(0);

            $table->decimal('percentage', 5, 2)
                ->default(0);

            $table->boolean('passed')
                ->default(false);

            $table->string('status')
                ->default('in_progress');

            $table->unsignedInteger('time_taken')
                ->default(0);

            $table->timestamps();

            $table->index([
                'student_id',
                'test_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};
