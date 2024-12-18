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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_type_id')->constrained('ledger_types')->onDelete('cascade');
            $table->foreignId('transaction_purpose_id')->constrained('transaction_purposes')->onDelete('cascade');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('set null');
            $table->foreignId('transaction_item_id')->nullable()->constrained('transaction_items')->onDelete('set null');
            $table->text('description')->nullable();
            $table->decimal('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 15, 2);
            $table->enum('is_paid', ['paid', 'due'])->default('due');
            $table->date('paid_date')->nullable();
            $table->date('buy_or_sell_date');
            $table->string('payment_method')->nullable(); // COD, Bkash, etc.
            $table->string('transaction_id')->nullable(); // Transaction ID for payments
            $table->string('voucher')->nullable();
            $table->foreignId('created_by')->constrained('users'); // User who created the record
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
