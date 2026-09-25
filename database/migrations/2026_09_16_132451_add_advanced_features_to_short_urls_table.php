<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {

            // Maximum allowed clicks
            // NULL = unlimited
            $table->unsignedBigInteger('click_limit')
                ->nullable()
                ->after('expires_at');

            // Password protection
            // Password will be stored as a hash
            $table->string('password')
                ->nullable()
                ->after('click_limit');

            // Whether QR code should be generated
            $table->boolean('qr_enabled')
                ->default(false)
                ->after('password');

        });
    }

    public function down(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {

            $table->dropColumn([
                'click_limit',
                'password',
                'qr_enabled',
            ]);

        });
    }
};
