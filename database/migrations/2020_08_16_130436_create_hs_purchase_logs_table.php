<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsPurchaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_purchase_log', function (Blueprint $table) {
            $table->increments('prlg_id');
            $table->integer('prch_id')->unsigned();
            $table->string('action', 20);
            $table->integer('user_id')->unsigned();
            $table->datetime('log_date_time');
            $table->foreign('prch_id')->references('prch_id')->on('hs_purchase');
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
        Schema::dropIfExists('hs_purchase_log');
    }
}
