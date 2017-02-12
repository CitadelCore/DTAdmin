<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bans', function(Blueprint $table) {
          $table->increments('banid');
          $table->integer('serverid')->length(10);
          $table->string('playerbanned', 30);
          $table->string('timebanned', 50);
          $table->boolean('unbanned');
          $table->string('bannedby', 50);
          $table->string('bannedon', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('bans');
    }
}
