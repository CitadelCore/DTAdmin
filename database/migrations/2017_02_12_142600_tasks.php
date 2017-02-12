<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tasks', function(Blueprint $table) {
          $table->increments('taskid');
          $table->integer('userid')->length(10);
          $table->integer('percentcomplete')->length(3);
          $table->string('colour', 30);
          $table->boolean('completed');
          $table->longText('message');
          $table->string('link', 100);
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
        Schema::drop('tasks');
    }
}
