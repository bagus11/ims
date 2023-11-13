<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinQuantityOnRequestModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_model', function (Blueprint $table) {
            $table->integer('min_quantity');
            $table->integer('quantity_buffer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_model', function (Blueprint $table) {
            $table->dropColumn('min_quantity');
            $table->dropColumn('quantity_buffer');
        });
    }
}
