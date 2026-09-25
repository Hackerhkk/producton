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
        Schema::create('short_url_clicks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('short_url_id')
                ->constrained('short_urls')
                ->cascadeOnDelete();

            $table->string('ip_address', 45)->nullable();

            $table->string('user_agent', 1000)->nullable();

            $table->string('device', 30)->nullable();

            $table->string('browser', 100)->nullable();

            $table->string('os', 100)->nullable();

            $table->string('referer', 1000)->nullable();

            $table->timestamp('clicked_at');

            $table->timestamps();

            $table->index([
                'short_url_id',
                'clicked_at'
            ]);

            $table->index('device');
            $table->index('browser');
            $table->index('os');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_url_clicks');
    }
};