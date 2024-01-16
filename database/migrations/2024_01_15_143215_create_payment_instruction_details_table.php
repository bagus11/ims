<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInstructionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_instruction_detail', function (Blueprint $table) {
            $table->id();
            $table->string('pi_code');
            $table->string('pc_code');
            $table->integer('user_id');
            $table->integer('pic_id');
            $table->integer('subcategory_id');
            $table->string('subcategory_name');
            $table->double('payment');
            $table->string('attachment');
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
        Schema::dropIfExists('payment_instruction_detail');
    }
}
