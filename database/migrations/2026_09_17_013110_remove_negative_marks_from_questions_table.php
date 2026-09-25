<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropColumn('negative_marks');
    });
}

public function down(): void
{
    Schema::table('questions', function (Blueprint $table) {
        $table->decimal('negative_marks', 5, 2)->default(0);
    });
}
};
