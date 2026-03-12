<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**​ php artisan migrate:refresh --path=database/migrations/2026_03_10_030338_create_sells_table.php
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable(); // បន្ថែម column ឈ្មោះអតិថិជន
            $table->string('invoice_no')->unique();
            $table->date('sell_date');
            $table->decimal('total_amount',10,2);
            $table->decimal('grand_total',10,2);
            $table->decimal('paid_amount',10,2)->default(0);
            $table->decimal('due_amount',10,2)->default(0);
            $table->string('status')->default('unpaid');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('sells');
    }
};
