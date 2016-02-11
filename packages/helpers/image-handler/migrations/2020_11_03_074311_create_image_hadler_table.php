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
            $table->text('original_name');
            $table->text('preferences');
            $table->string('session_token', 64)->nullable();
            $table->boolean('preview');
            $table->integer('imageable_id')->nullable();//imageable_id - integer
            $table->string('imageable_type')->nullable();//imageable_type - string

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
