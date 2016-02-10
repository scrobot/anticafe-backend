<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageHadlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function(Blueprint $table) {

            $table->increments('id');
            $table->text('filename');
            $table->text('preferences');
            $table->integer('imageable_id');//imageable_id - integer
            $table->string('imageable_type');//imageable_type - string

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
