<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAnticafesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anticafes', function (Blueprint $table) {
            $table->text('description')->nullable()->after('prices');
            $table->string('vk')->nullable()->after('phone');
            $table->string('ok')->nullable()->after('phone');
            $table->string('fb')->nullable()->after('phone');
            $table->string('tw')->nullable()->after('phone');
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
            $table->dropColumn(
              'description',
              'vk',
              'ok',
              'fb',
              'tw'
            );
        });
    }
}
