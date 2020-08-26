<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_item_detail', function (Blueprint $table) {
            $table->increments('itdt_id');
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 38, 2);
            $table->integer('splr_id')->unsigned();
            $table->integer('itcg_id')->unsigned();
            $table->decimal('quantity', 21, 2);
            $table->foreign('splr_id')->references('splr_id')->on('hs_supplier');
            $table->foreign('itcg_id')->references('itcg_id')->on('hs_item_category');
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
        Schema::dropIfExists('hs_item_detail');
    }
}
