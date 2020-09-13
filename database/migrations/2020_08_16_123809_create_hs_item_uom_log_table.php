<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsItemUomLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_item_uom_log', function (Blueprint $table) {
            $table->increments('itul_id');
            $table->integer('ituo_id')->unsigned();
            $table->string('action', 20);
            $table->integer('user_id')->unsigned();
            $table->datetime('log_date_time');
            $table->foreign('ituo_id')->references('ituo_id')->on('hs_item_uom');
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
        Schema::dropIfExists('hs_item_uom_log');
    }
}
