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
        Schema::create('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('img', 50)->nullable();
            $table->integer('shop_id');
            $table->string('branch_name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('formed_date')->nullable();
            $table->integer('manager_id');
            $table->tinyInteger('is_default')->default(0);
            $table->integer('category')->default(0);
            $table->string('email')->nullable();
            $table->enum('status', ['active', 'deleted'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
