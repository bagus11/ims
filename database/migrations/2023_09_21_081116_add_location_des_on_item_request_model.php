<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationDesOnItemRequestModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_request_model', function (Blueprint $table) {
            $table->integer('des_location_id')->after('location_id');
            $table->integer('approval_id')->after('user_id');
            $table->integer('step')->after('approval_id');
            $table->integer('approval_status')->after('status');
            $table->string('attachment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_request_model', function (Blueprint $table) {
            $table->dropColumn('des_location_id');
            $table->dropColumn('approval_id');
            $table->dropColumn('step');
            $table->dropColumn('attachment');
            $table->dropColumn('approval_status');
        });
    }
}
