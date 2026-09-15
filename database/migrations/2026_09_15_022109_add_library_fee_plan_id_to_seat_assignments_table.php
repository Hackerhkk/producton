<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('seat_assignments', function (Blueprint $table) {
        $table->foreignId('library_fee_plan_id')
            ->nullable()
            ->after('fees_id')
            ->constrained('library_fee_plans')
            ->restrictOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::table('seat_assignments', function (Blueprint $table) {
        $table->dropForeign(['library_fee_plan_id']);
        $table->dropColumn('library_fee_plan_id');
    });
}
};
