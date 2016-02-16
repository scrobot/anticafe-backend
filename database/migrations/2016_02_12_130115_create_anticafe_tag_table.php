<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticafeTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticafe_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('anticafe_id');
            $table->unsignedInteger('tag_id');
            $table->index('anticafe_id', 'tag_id');
            $table->foreign('anticafe_id')->references('id')->on('anticafes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('anticafe_tag')->truncate();
        Schema::drop('anticafe_tag');
    }
}
