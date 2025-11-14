<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** php artisan migrate:refresh --path=database/migrations/2025_11_01_031919_create_sliders_table.php
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
           $table->id();
            $table->string('title', 255)->nullable();
            $table->string('image_slider', 255); // Assuming this is the image file path/name
            $table->enum('type', ['main', 'banner', 'small'])->default('main');
            $table->string('link', 255)->nullable();
            // ✅ Add the status column here
            // 0: Pending, 1: Publish, 2: Un-Publish (based on your Blade view)
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
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
