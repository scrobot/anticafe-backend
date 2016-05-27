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
        Schema::create('statistics_installs', function(Blueprint $table) {
            $table->increments('id');
            $table->string("type");
            $table->unsignedInteger("client_id");
            $table->index("client_id")->nullable();
            $table->foreign('client_id')->references('id')->on("clients")->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('statistics_buttons', function(Blueprint $table) {
            $table->increments('id');
            $table->string("button");
            $table->string("type");
            $table->unsignedInteger("client_id");
            $table->index("client_id")->nullable();
            $table->foreign('client_id')->references('id')->on("clients")->onDelete('cascade');
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
        Schema::drop('statistics_installs');
        Schema::drop('statistics_buttons');
    }
}
