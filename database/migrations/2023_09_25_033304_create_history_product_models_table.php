<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryProductModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_product_model', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('request_code');
            $table->integer('source_location');
            $table->integer('destination_location');
            $table->integer('quantity');
            $table->integer('quantity_request');
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
        Schema::dropIfExists('history_product_model');
    }
}
