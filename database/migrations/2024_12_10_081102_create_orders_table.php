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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_sku')->unique();
            $table->enum('payment_type', ['COD', 'Bkash', 'Rocket', 'Nagad']);
            $table->foreignId('paid_by')->nullable()->constrained('users');
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('transaction_id')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('delivery_type', ['free', 'paid'])->default('paid');
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
