<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsSupplierLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_supplier_log', function (Blueprint $table) {
            $table->increments('splg_id');
            $table->integer('splr_id')->unsigned();
            $table->string('action', 20);
            $table->integer('user_id')->unsigned();
            $table->datetime('log_date_time');
            $table->foreign('splr_id')->references('splr_id')->on('hs_supplier');
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
        Schema::dropIfExists('hs_supplier_log');
    }
}
