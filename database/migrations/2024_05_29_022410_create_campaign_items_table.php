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
        Schema::create('campaign_items', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedInteger('item_id');
            $table->integer('sub_item_id');
            $table->integer('quantity');
            $table->integer('amount');
            $table->string('campaign_id', 32)->nullable();
            $table->string('item_code', 32);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_items');
    }
};
