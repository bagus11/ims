<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashSubModelRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pettycash_subcategory_request', function (Blueprint $table) {
            $table->id();
            $table->string('pc_code');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('subcategory_name');
            $table->float('amount');
            $table->integer('user_id');
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
        Schema::dropIfExists('pettycash_subcategory_request');
    }
}
