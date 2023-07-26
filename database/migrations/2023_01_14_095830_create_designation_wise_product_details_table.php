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
        Schema::create('designation_wise_product_details', function (Blueprint $table) {
            $table->id();
            $table->integer('designation_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('product_type_id')->nullable();
            $table->decimal('quantity')->default(0);
            $table->string('tok')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('designation_wise_product_details');
    }
};
