<?php

use App\Enums\ShopStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('img', 50)->nullable();
            $table->integer('user_id')->length(10);
            $table->string('name', 32);
            $table->string('phone', 50)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('email', 100)->nullable();
            $table->date("formed_date")->nullable();
            $table->enum('status', ShopStatusEnum::getValueArray())->default(ShopStatusEnum::Active->value); // 'active' is the default value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
