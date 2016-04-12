<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientAuthToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn("uid", 'token');
            $table->string("authToken")->nullable();
            $table->boolean("facebook");
            $table->boolean("vkontakte");
            $table->bigInteger("vk_uid")->nullbale();
            $table->bigInteger("fb_uid")->nullbale();
            $table->string("vk_token")->nullbale();
            $table->string("fb_token")->nullbale();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer("uid")->nullbale();
            $table->string("token")->nullbale();
            $table->dropColumn("authToken", 'facebook', 'vkontakte', 'vk_uid', 'fb_uid', 'vk_token', 'fb_token');
        });
    }
}
