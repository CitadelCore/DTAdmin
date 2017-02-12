<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Staffranks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('staffranks', function(Blueprint $table) {
          $table->increments('rankid');
          $table->integer('serverid')->length(10);
          $table->string('userranked', 30);
          $table->string('timeranked', 50);
          $table->boolean('unranked');
          $table->string('rankedby', 50);
          $table->string('rankedon', 50);
          $table->string('serverrank', 50);
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
        Schema::drop('staffranks');
    }
}
