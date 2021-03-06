<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAliasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alias_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('alias_id');
            $table->unsignedInteger('tag_id');
            $table->index('alias_id', 'tag_id');
            $table->foreign('alias_id')->references('id')->on('aliases')->onDelete('cascade');
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
        \DB::table('alias_tag')->truncate();
        Schema::drop('alias_tag');
    }
}
