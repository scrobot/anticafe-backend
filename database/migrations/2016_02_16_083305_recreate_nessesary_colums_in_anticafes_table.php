<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateNessesaryColumsInAnticafesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anticafes', function (Blueprint $table) {
            $table->string('address')->nullable()->after('prices');
            $table->text('event_address')->nullable()->after('prices');
            $table->string('phone')->nullable()->after('prices');
            $table->text('metro')->nullable()->after('prices');
            $table->string('city')->nullable()->after('prices');
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
            $table->dropColumn('event_address', 'address', 'phone', 'metro', 'city');
        });
    }
}
