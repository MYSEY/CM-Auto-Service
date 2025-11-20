<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**​ php artisan migrate:refresh --path=database/migrations/2025_11_15_065316_create_engines_table.php
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_category_id')->nullable();
            $table->string('name');
            $table->string('part_number')->nullable();
            $table->string('slug');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
