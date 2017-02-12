<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('messages', function(Blueprint $table) {
          $table->increments('messageid');
          $table->integer('useridto')->length(10);
          $table->integer('useridfrom')->length(10);
          $table->longText('message');
          $table->string('timesent', 100);
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
        Schema::drop('messages');
    }
}
