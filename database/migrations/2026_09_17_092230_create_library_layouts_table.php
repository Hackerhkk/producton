<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_layouts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_id')
                ->unique()
                ->constrained('libraries')
                ->cascadeOnDelete();

            $table->unsignedInteger('width')->default(1200);
            $table->unsignedInteger('height')->default(700);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_layouts');
    }
};