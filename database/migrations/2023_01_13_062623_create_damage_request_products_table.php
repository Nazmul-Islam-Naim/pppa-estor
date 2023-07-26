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
        Schema::create('damage_request_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_request_id')->constrained('damage_requests')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->date('adjusted')->default(null);
            $table->integer('quantity');
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
        Schema::dropIfExists('damage_request_products');
    }
};
