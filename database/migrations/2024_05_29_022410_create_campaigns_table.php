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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedInteger('shop_id');
            $table->string('post_id', 32)->nullable();
            $table->integer('page_id');
            $table->tinyInteger('is_live_sale')->default(1);
            $table->string('title', 32);
            $table->text('description')->nullable();
            $table->tinyInteger('channel_id');
            $table->integer('branch_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('updated_by');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
