<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mailserver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mailserver', function(Blueprint $table) {
          $table->increments('serverid');
          $table->string('hostname', 10);
          $table->boolean('sslenabled');
          $table->boolean('autossl');
          $table->integer('port')->length(10);
          $table->boolean('authenticated');
          $table->string('username', 50);
          $table->string('password', 50);
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
        Schema::drop('mailserver');
    }
}
