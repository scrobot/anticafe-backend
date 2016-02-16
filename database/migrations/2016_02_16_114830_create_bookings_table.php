<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count_of_customers');
            $table->text('comment');
            $table->text('contacts');
            $table->string('status');
            $table->timestamp('arrival_at');
            $table->unsignedInteger('anticafe_id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('user_id');
            $table->index('anticafe_id', 'client_id', 'user_id');
            $table->foreign('anticafe_id')->references('id')->on('anticafes')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('bookings');
    }
}
