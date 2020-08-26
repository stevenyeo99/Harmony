<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_invoice', function (Blueprint $table) {
            $table->increments('invc_id');
            $table->decimal('sub_total', 38, 2);
            $table->datetime('invoice_datetime');
            $table->string('invoice_no', 20)->unique();
            $table->string('status', 10);
            $table->decimal('paid_amt', 38, 2);
            $table->decimal('return_amt', 38, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_invoice');
    }
}
