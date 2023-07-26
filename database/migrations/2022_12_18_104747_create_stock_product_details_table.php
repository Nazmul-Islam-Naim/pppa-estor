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
        Schema::create('stock_product_details', function (Blueprint $table) {
            $table->id(); 
            $table->date('date')->nullable();
            $table->integer('product_id')->nullable();
            $table->decimal('quantity')->default(0);
            $table->decimal('unit_price')->default(0);
            $table->string('reason')->nullable();
            $table->string('tok')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('stock_product_details');
    }
};
