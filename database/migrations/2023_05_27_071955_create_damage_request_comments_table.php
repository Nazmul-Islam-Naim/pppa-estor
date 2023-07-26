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
        Schema::create('damage_request_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_request_id')->constrained('damage_requests')->onDelete('cascade');
            $table->text('comment');
            $table->boolean('status')->default(true);
            $table->foreignId('user_id')->nullValue()->constrained('users');
            $table->enum('type',['Approved','Declined','Published','Confirmed'])->default('Approved');
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
        Schema::dropIfExists('damage_request_comments');
    }
};
