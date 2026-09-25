<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->foreignId('user_subscription_id')
            ->nullable()
            ->constrained('user_subscriptions')
            ->nullOnDelete();

        $table->string('razorpay_order_id')->nullable()->index();
        $table->string('razorpay_payment_id')->nullable()->unique();

        $table->decimal('amount', 10, 2);
        $table->string('currency', 10)->default('INR');

        $table->string('status')->default('created');

        $table->timestamp('paid_at')->nullable();

        $table->json('gateway_response')->nullable();

        $table->timestamps();

        $table->index(['user_id', 'status']);
    });
}

public function down(): void
{
    Schema::dropIfExists('payments');
}


};
