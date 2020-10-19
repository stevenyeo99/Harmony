<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_purchase', function (Blueprint $table) {
            $table->increments('prch_id');
            $table->integer('splr_id')->unsigned();
            $table->decimal('sub_total', 38, 2);
            $table->datetime('purchase_datetime');
            $table->string('po_no', 20)->unique()->nullable();
            $table->string('status', 10);
            $table->foreign('splr_id')->references('splr_id')->on('hs_supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_purchase');
    }
}
