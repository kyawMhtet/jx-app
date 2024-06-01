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
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('order_number', 10);
            $table->unsignedInteger('branch_id')->default(1);
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('customer_id');
            $table->integer('item_count')->default(0);
            $table->unsignedInteger('sub_total');
            $table->unsignedInteger('total');
            $table->string('payment_method', 10);
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('tax')->default(0);
            $table->unsignedInteger('charges')->default(0);
            $table->string('name', 30)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('note', 500)->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_name', 30)->nullable();
            $table->string('delivery_address', 500)->nullable();
            $table->string('delivery_phone', 32)->nullable();
            $table->date('order_date')->nullable();
            $table->enum('status', ['new_order', 'confirmed_order', 'payment_pending', 'cancel_order', 'placed_order', 'reject_order', 'shipped_order', 'return_order', 'delivered_order', 'completed_order', 'pending', 'delivery', 'completed', 'cancelled', 'deleted', 'checkout'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
