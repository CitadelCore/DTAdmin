<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Servers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('servers', function(Blueprint $table) {
          $table->increments('serverid');
          $table->string('servername', 30);
          $table->string('currentstatus', 30);
          $table->integer('currentplayercount')->length(30);
          $table->string('timesincelastsd', 30);
          $table->string('gamemode', 30);
          $table->string('gameserver', 30);
          $table->integer('operator')->length(10);
          $table->integer('maxraminmb')->length(30);
          $table->integer('freeraminmb')->length(30);
          $table->integer('cpuusagepercent')->length(3);
          $table->string('ipaddress', 100);
          $table->string('hostname', 100);
          $table->integer('queryportdefault')->length(10);
          $table->integer('queryportdtadmin')->length(10);
          $table->string('rconpassword', 30);
          $table->string('dtqueryseckey', 50);
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
        Schema::drop('servers');
    }
}
