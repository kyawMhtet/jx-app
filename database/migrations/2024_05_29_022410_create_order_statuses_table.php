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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->integer('order_id');
            $table->dateTime('new_order')->nullable();
            $table->dateTime('confirmed_order')->nullable();
            $table->dateTime('payment_pending')->nullable();
            $table->dateTime('cancel_order')->nullable();
            $table->dateTime('placed_order')->nullable();
            $table->dateTime('reject_order')->nullable();
            $table->dateTime('shipped_order')->nullable();
            $table->dateTime('return_order')->nullable();
            $table->dateTime('delivered_order')->nullable();
            $table->dateTime('completed_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
