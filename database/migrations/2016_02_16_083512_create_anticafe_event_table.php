<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticafeEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticafe_event', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('anticafe_id');
            $table->unsignedInteger('event_id');
            $table->index('anticafe_id', 'event_id');
            $table->foreign('anticafe_id')->references('id')->on('anticafes');
            $table->foreign('event_id')->references('id')->on('anticafes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('anticafe_event')->truncate();
        Schema::drop('anticafe_event');
    }
}
