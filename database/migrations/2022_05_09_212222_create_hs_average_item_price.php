<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsAverageItemPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_average_item_price', function (Blueprint $table) {
            $table->increments('avgi_id');
            $table->integer('itdt_id')->unsigned();
            $table->decimal('quantity', 21, 2);
            $table->decimal('price', 38, 2);
            $table->decimal('total_price', 38, 2);
            $table->foreign('itdt_id')->references('itdt_id')->on('hs_item_detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_average_item_price');
    }
}
