<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_reports', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable();
            $table->integer('bank_id')->nullable();
            $table->decimal('amount',15,2)->nullable();
            $table->string('keyword')->nullable();
            $table->text('reason')->nullable();
            $table->text('note')->nullable();
            $table->string('tok')->nullable();
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
        Schema::dropIfExists('transaction_reports');
    }
}
