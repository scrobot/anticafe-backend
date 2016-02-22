<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticafeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticafe_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('anticafe_id');
            $table->unsignedInteger('user_id');
            $table->index('user_id', 'anticafe_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('anticafe_id')->references('id')->on('anticafes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('anticafe_user')->truncate();
        Schema::drop('anticafe_user');
    }
}
