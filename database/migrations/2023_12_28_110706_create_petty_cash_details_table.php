<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_detail', function (Blueprint $table) {
            $table->id();
            $table->string('pc_code');
            $table->float('amount');
            $table->integer('category_id');
            $table->integer('status');
            $table->integer('user_id');
            $table->integer('pic_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('remark');
            $table->string('attachment');
            $table->integer('location');
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
        Schema::dropIfExists('petty_cash_detail');
    }
}
