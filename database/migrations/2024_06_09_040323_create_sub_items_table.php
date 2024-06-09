<?php

use App\Enums\SubItemStatusEnum;
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
        Schema::create('sub_items', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->integer('branch_id')->length(10)->unsigned()->default(0);
            $table->integer('item_id')->unsigned();
            $table->string('sku', 10);
            $table->string('sub_item_name', 200)->nullable();
            $table->string('color', 32)->nullable();
            $table->string('size', 32)->nullable();
            $table->string('model', 32)->nullable();
            $table->string('other', 32)->nullable();
            $table->string('inventory_code', 10)->default(1);
            $table->integer('price')->length(10)->unsigned();
            $table->integer('stock')->length(5)->unsigned();
            $table->string('image_url', 500)->nullable();
            $table->enum('status', SubItemStatusEnum::getValueArray())->default(SubItemStatusEnum::Active->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_items');
    }
};
