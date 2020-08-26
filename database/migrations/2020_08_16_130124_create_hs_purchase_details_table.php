<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_purchase_detail', function (Blueprint $table) {
            $table->increments('prdt_id');
            $table->integer('prch_id')->unsigned();
            $table->integer('itdt_id')->unsigned();
            $table->decimal('quantity', 21, 2);
            $table->decimal('sub_total', 38, 2);
            $table->foreign('prch_id')->references('prch_id')->on('hs_purchase');
            $table->foreign('itdt_id')->references('itdt_id')->on('hs_item_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_purchase_detail');
    }
}
