<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_name', 50);
            $table->string('email', 50)->unique();
            $table->string('phone', 50);
            $table->string('password');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('is_admin', 10);
            $table->string('permission_type', 20);
            $table->string('status', 10);
            $table->rememberToken();
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
        Schema::dropIfExists('hs_user');
    }
}
