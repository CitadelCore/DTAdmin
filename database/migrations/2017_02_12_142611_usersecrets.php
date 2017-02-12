<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usersecrets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('usersecrets', function(Blueprint $table) {
          $table->increments('secretid');
          $table->integer('userid')->length(10);
          $table->string('secretkey', 50);
          $table->text('note');
          $table->string('timecreated', 100);
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
        Schema::drop('usersecrets');
    }
}
