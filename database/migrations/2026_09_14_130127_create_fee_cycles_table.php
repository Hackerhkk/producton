<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_cycles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('seat_assignment_id')
                ->constrained('seat_assignments')
                ->cascadeOnDelete();

            $table->foreignId('fees_id')
                ->constrained('fees')
                ->restrictOnDelete();

            $table->date('period_start');

            $table->date('period_end');

            $table->decimal('amount', 10, 2);

            $table->decimal('paid_amount', 10, 2)->default(0);

            $table->string('status')->default('pending');
            // pending / paid / partial / cancelled

            $table->date('paid_date')->nullable();

            $table->foreignId('wallet_transaction_id')
                ->nullable()
                ->constrained('wallet_transactions')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'student_id',
                'period_start',
                'period_end'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_cycles');
    }
};