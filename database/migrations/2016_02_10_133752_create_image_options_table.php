<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('width');
            $table->integer('height');
            $table->string('anchor');
            $table->boolean('relative');
            $table->string('bgcolor')->default('#000000');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image_options');
    }
}
