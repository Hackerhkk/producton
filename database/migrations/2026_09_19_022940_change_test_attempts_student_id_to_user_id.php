<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Existing test attempts currently use students.id.
         * Convert that relation to users.id before removing student_id.
         */
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('test_id');
        });

        DB::statement('
            UPDATE test_attempts ta
            INNER JOIN students s ON s.id = ta.student_id
            SET ta.user_id = s.user_id
            WHERE ta.student_id IS NOT NULL
        ');

        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropIndex('test_attempts_student_id_test_id_index');
            $table->dropColumn('student_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->index(['user_id', 'test_id']);
        });
    }

    public function down(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->after('test_id');
        });

        /*
         * Restore student_id using the user's linked student.
         */
        DB::statement('
            UPDATE test_attempts ta
            INNER JOIN students s ON s.user_id = ta.user_id
            SET ta.student_id = s.id
            WHERE ta.user_id IS NOT NULL
        ');

        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('test_attempts_user_id_test_id_index');
            $table->dropColumn('user_id');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->cascadeOnDelete();

            $table->index(['student_id', 'test_id']);
        });
    }
};
