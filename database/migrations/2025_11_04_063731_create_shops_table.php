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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->text('logo_company')->nullable();
            $table->text('description')->nullable();
            $table->string('home_no')->nullable();
            $table->string('street_no')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('commune')->nullable();
            $table->string('village')->nullable();
            $table->text('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('shops');
    }
};
