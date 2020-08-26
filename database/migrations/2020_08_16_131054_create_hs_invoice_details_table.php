<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_invoice_detail', function (Blueprint $table) {
            $table->increments('ivdt_id');
            $table->integer('invc_id')->unsigned();
            $table->decimal('quantity', 21, 2);
            $table->decimal('price', 38, 2);
            $table->decimal('sub_total', 38, 2);
            $table->foreign('invc_id')->references('invc_id')->on('hs_invoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_invoice_detail');
    }
}
