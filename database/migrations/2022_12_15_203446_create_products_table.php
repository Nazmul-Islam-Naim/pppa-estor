<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('product_type_id')->nullable();
            $table->integer('product_category_id')->nullable();
            $table->integer('product_sub_category_id')->nullable();
            $table->integer('product_unit_id')->nullable();
            $table->integer('product_brand_id')->nullable();
            $table->decimal('stock_notify')->default(0);
            $table->text('note')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
