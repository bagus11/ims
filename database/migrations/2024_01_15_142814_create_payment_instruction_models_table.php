<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInstructionModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_instruction', function (Blueprint $table) {
            $table->id();
            $table->string('pi_code');
            $table->string('pc_code');
            $table->double('amount_request');
            $table->double('amount_approve');
            $table->double('payment');
            $table->double('amount_remaining');
            $table->integer('user_id');
            $table->integer('pic_id');
            $table->integer('approval_id');
            $table->integer('status');
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
        Schema::dropIfExists('payment_instruction');
    }
}
