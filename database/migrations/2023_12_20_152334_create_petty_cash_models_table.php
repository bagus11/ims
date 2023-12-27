<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_model', function (Blueprint $table) {
            $table->id();
            $table->string('pc_code');
            $table->integer('location_id');
            $table->integer('user_id');
            $table->integer('pic');
            $table->integer('current_approval');
            $table->integer('status');
            $table->string('attachment');
            $table->text('remark');
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
        Schema::dropIfExists('petty_cash_model');
    }
}
