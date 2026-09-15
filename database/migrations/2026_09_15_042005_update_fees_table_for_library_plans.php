
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {

            $table->foreignId('library_id')
                ->after('id')
                ->nullable()
                ->constrained('libraries')
                ->cascadeOnDelete();

            $table->dropColumn([
                'duration',
                'duration_type',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {

            $table->dropForeign(['library_id']);

            $table->dropColumn('library_id');

            $table->integer('duration')
                ->default(1);

            $table->string('duration_type')
                ->default('month');
        });
    }
};

