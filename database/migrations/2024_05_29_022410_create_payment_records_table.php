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
        Schema::create('payment_records', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->integer('page_id');
            $table->integer('customer_id');
            $table->integer('order_id');
            $table->string('image_url', 500);
            $table->enum('state', ['payment_pending', 'payment_received', 'payment_confirmed', 'payment_reject']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_records');
    }
};
