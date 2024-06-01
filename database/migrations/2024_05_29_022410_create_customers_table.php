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
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('channel_customer_id', 20);
            $table->string('channel_id', 10);
            $table->integer('branch_id')->default(1);
            $table->string('gender', 10)->nullable();
            $table->date('birthday')->nullable();
            $table->string('customer_name', 32);
            $table->string('acc_name', 100)->nullable();
            $table->string('email', 32)->nullable();
            $table->string('phone', 32)->nullable();
            $table->text('address')->nullable();
            $table->string('delivery_name', 32)->nullable();
            $table->string('delivery_contact', 32)->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('contact', 20)->nullable();
            $table->string('profile_pic_url', 500)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->enum('state', ['payment_pending', 'payment_received', 'NA'])->nullable();
            $table->string('state_value', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
