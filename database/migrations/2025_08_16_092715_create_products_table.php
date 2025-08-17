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
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->foreignId('sub_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('unit')->nullable()->comment('e.g., kg, piece, liter');
            $table->string('thumbnail_image');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            // Shipping
            $table->decimal('package_weight', 8, 2)->nullable()->comment('in kg');
            $table->decimal('package_length', 8, 2)->nullable()->comment('in cm');
            $table->decimal('package_width', 8, 2)->nullable()->comment('in cm');
            $table->decimal('package_height', 8, 2)->nullable()->comment('in cm');
            // Warranty
            $table->string('warranty_type')->nullable();
            $table->string('warranty_period')->nullable();
            $table->text('warranty_policy')->nullable();
            // Others
            $table->string('free_item')->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
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
