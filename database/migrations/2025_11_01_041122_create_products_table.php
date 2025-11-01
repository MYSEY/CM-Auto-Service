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
            $table->integer('status_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('product_photo');
            $table->float('price')->default(0);
            $table->string('view_counter')->nullable();
            $table->string('delivery_note')->nullable();
            $table->float('discount_price')->default(0);
            $table->text('content');
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
        Schema::dropIfExists('products');
    }
};
