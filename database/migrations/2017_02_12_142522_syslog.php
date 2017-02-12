<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Syslog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('syslog', function(Blueprint $table) {
          $table->increments('event');
          $table->integer('user_id')->length(11);
          $table->string('time', 30);
          $table->string('reason', 30);
          $table->string('clientip', 100);
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
        Schema::drop('syslog');
    }
}
