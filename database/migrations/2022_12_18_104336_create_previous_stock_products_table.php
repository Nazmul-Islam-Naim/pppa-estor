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
        Schema::create('previous_stock_products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->decimal('unit_price')->default(0);
            $table->decimal('quantity')->default(0);
            $table->date('stock_date')->nullable();
            $table->string('tok')->nullable();
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
        Schema::dropIfExists('previous_stock_products');
    }
};
