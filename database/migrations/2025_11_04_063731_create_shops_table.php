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
            $table->string('provinc')->nullable();
            $table->string('distric')->nullable();
            $table->string('commun')->nullable();
            $table->string('villag')->nullable();
            $table->text('location')->nullable();
            $table->string('phone_one')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('wechat')->nullable();
            $table->string('website')->nullable();
            $table->boolean('status')->default(0);
            $table->bigInteger('updated_by');
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
