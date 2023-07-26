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
        Schema::create('damage_requests', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('username');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0); //1: Approved by authorized user 2: Approved by shop keeper 3:approved by user
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
        Schema::dropIfExists('damage_requests');
    }
};
