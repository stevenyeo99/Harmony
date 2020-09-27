<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsItemStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_item_stock_log', function (Blueprint $table) {
            $table->increments('itsk_id');
            $table->integer('itdt_id')->unsigned();
            $table->decimal('original_quantity', 21, 2);
            $table->decimal('add_quantity', 21, 2);
            $table->decimal('min_quantity', 21, 2);
            $table->integer('prdt_id')->unsigned()->nullable();
            $table->integer('ivdt_id')->unsigned()->nullable();
            $table->string('change_type', 20);
            $table->datetime('change_time');
            $table->decimal('new_quantity', 21, 2);
            $table->text('description');
            $table->integer('user_id')->unsigned();
            $table->foreign('itdt_id')->references('itdt_id')->on('hs_item_detail');
            $table->foreign('prdt_id')->references('prdt_id')->on('hs_purchase_detail');
            $table->foreign('ivdt_id')->references('ivdt_id')->on('hs_invoice_detail');
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
        Schema::dropIfExists('hs_item_stock_log');
    }
}
