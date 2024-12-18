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
        Schema::create('transaction_purposes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_type_id')->constrained('ledger_types')->onDelete('cascade');
            $table->string('name'); // 'Salary', 'Marketing', 'Logistics', etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_purposes');
    }
};
