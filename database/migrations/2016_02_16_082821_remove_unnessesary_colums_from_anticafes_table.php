<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnnessesaryColumsFromAnticafesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anticafes', function (Blueprint $table) {
            $table->dropColumn('routine', 'address', 'phone', 'metro', 'city');
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
            $table->string('city');
            $table->text('metro');
            $table->string('address');
            $table->string('routine');
            $table->string('phone');
        });
    }
}
