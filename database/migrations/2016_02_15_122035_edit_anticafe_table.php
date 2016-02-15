<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAnticafeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anticafes', function (Blueprint $table) {
            $table->text('excerpt')->after('prices')->nullable();
            $table->integer('type')->after('phone')->default(0);
            $table->timestamp('start_at');
            $table->timestamp('end_at');
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
            $table->dropColumn('excerpt','start_at','end_at', 'type');
        });
    }
}
