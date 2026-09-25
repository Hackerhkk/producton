<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {

            // Link kab se active hoga
            $table->timestamp('starts_at')
                ->nullable()
                ->after('status');

            // Link kab expire hoga
            $table->timestamp('expires_at')
                ->nullable()
                ->after('starts_at');

        });
    }

    public function down(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {

            $table->dropColumn([
                'starts_at',
                'expires_at',
            ]);

        });
    }
};
