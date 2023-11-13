<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnItemRequestDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_request_detail', function (Blueprint $table) {
            $table->integer('approval_id')->after('user_id');
            $table->integer('des_location_id')->after('user_id');
            $table->integer('step')->after('user_id');
            $table->integer('approval_status')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_request_detail', function (Blueprint $table) {
            $table->dropColumn('approval_id');
            $table->dropColumn('des_location_id');
            $table->dropColumn('step');
            $table->dropColumn('approval_status');
        });
    }
}
