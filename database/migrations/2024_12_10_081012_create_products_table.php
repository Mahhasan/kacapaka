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
         Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('position')->default(0); // Position for ordering
            $table->boolean('is_active')->default(true);
            $table->boolean('has_delivery_free')->default(true); // Free delivery flag
            $table->string('image')->nullable(); // Main image
            $table->foreignId('created_by')->constrained('users'); // Admin who created it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
