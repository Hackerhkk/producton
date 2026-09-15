<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('library_fee_plans', function (Blueprint $table) {

        $table->id();

        $table->foreignId('library_id')
            ->constrained('libraries')
            ->cascadeOnDelete();

        $table->foreignId('fees_id')
            ->constrained('fees')
            ->restrictOnDelete();

        $table->decimal('amount', 10, 2);

        $table->integer('duration')->default(1);

        $table->string('duration_type')->default('month');

        $table->boolean('status')->default(true);

        $table->timestamps();

        $table->index([
            'library_id',
            'fees_id'
        ]);
    });

    
}

public function down(): void
{
    Schema::dropIfExists('library_fee_plans');
}
};
