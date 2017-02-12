<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alerts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('alerts', function(Blueprint $table) {
          $table->increments('alertid');
          $table->integer('userid')->length(10);
          $table->string('priority', 30);
          $table->longText('message');
          $table->boolean('read');
          $table->string('link', 100);
          $table->string('icon', 100);
          $table->string('timeadded', 100);
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
        Schema::drop('alerts');
    }
}
