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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();

            // Media Type: 'image', 'video', or 'link'
            $table->string('media_type'); // 'image', 'video', or 'link'

            // Media URL for link-type media (e.g., URL for external video)
            $table->string('media_url')->nullable(); // For video link or image URL if used externally

            // Columns for image or video file upload
            $table->string('media_file_path')->nullable(); // Path to image or video uploaded from the device

            // Clickable link (if any, for redirection when clicked)
            $table->string('link')->nullable(); // Optional clickable link for redirection

            // Active status (whether the slider/banner is active or not)
            $table->boolean('is_active')->default(true);

            // Position (auto-detected last position, but editable)
            $table->integer('position')->default(0); // Editable position

            // Creator information (admin or user who created it)
            $table->foreignId('created_by')->constrained('users'); // Creator user ID

            // Timestamps
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
