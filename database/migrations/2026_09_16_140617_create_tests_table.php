<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {

            $table->id();

            $table->foreignId('test_series_id')
                ->constrained('test_series')
                ->cascadeOnDelete();

            $table->string('name');

            $table->unsignedInteger('duration')
                ->default(30);

            $table->unsignedInteger('total_questions')
                ->default(0);

            $table->decimal('total_marks', 8, 2)
                ->default(0);

            $table->decimal('passing_marks', 8, 2)
                ->default(0);

            $table->boolean('negative_marking')
                ->default(false);

            $table->decimal('negative_marks', 8, 2)
                ->default(0);

            $table->dateTime('starts_at')
                ->nullable();

            $table->dateTime('ends_at')
                ->nullable();

            $table->boolean('status')
                ->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
