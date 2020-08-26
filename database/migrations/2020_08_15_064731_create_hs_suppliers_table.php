<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_supplier', function (Blueprint $table) {
            $table->increments('splr_id');
            $table->string('code', 10)->unique();
            $table->string('name', 100);
            $table->string('address_line_1', 100);
            $table->string('address_line_2', 100)->nullable();
            $table->string('address_line_3', 100)->nullable();
            $table->string('address_line_4', 100)->nullable();
            $table->string('telp_no', 20);
            $table->string('contact_person_1', 20);
            $table->string('contact_person_2', 20)->nullable();
            $table->string('contact_person_3', 20)->nullable();
            $table->string('status', 10);
            $table->string('contact_name_1', 50);
            $table->string('contact_name_2', 50)->nullable();
            $table->string('contact_name_3', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_supplier');
    }
}
