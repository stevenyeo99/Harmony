<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsItemDetailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_item_detail_log', function (Blueprint $table) {
            $table->increments('itdl_id');
            $table->integer('itdt_id')->unsigned();
            $table->string('action', 20);
            $table->integer('user_id')->unsigned();
            $table->datetime('log_date_time');
            $table->foreign('itdt_id')->references('itdt_id')->on('hs_item_detail');
            $table->foreign('user_id')->references('user_id')->on('hs_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_item_detail_log');
    }
}
