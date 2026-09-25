<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_layout_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_layout_id')
                ->constrained('library_layouts')
                ->cascadeOnDelete();

            $table->string('type');

            $table->foreignId('seat_id')
                ->nullable()
                ->constrained('seats')
                ->nullOnDelete();

            $table->decimal('x', 10, 2)->default(0);
            $table->decimal('y', 10, 2)->default(0);

            $table->decimal('width', 10, 2)->default(60);
            $table->decimal('height', 10, 2)->default(60);

            $table->decimal('rotation', 10, 2)->default(0);

            $table->timestamps();

            $table->index(['library_layout_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_layout_items');
    }
};