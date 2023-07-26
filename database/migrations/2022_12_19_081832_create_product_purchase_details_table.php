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
        Schema::create('product_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->decimal('unit_price')->default(0);
            $table->decimal('quantity')->default(0);
            $table->string('tok')->nullable();
            $table->date('purchase_date')->nullable();
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
        Schema::dropIfExists('product_purchase_details');
    }
};
