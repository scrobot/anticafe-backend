<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalColunmToAnticafes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anticafes', function (Blueprint $table) {
            $table->integer('total_views');
            $table->integer('total_likes');
            $table->integer('total_bookings');
            $table->boolean('promo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anticafes', function (Blueprint $table) {
            $table->dropColumn('total_views', 'total_likes', 'total_bookings', 'promo');
        });
    }
}
