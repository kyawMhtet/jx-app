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
        Schema::create('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedInteger('channel_id');
            $table->string('page_id', 32);
            $table->string('page_name', 32);
            $table->string('category', 32)->nullable();
            $table->string('picture_url', 500)->nullable();
            $table->string('page_token', 500)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
