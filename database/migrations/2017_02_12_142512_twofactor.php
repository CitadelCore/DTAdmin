<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Twofactor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('2fa', function(Blueprint $table) {
          $table->increments('tokenid');
          $table->integer('userid')->length(60);
          $table->string('sharedsecret', 1800);
          $table->string('tokenuri', 1800);
          $table->string('qrcodeuri', 1800);
          $table->boolean('disabled');
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
        Schema::drop('2fa');
    }
}
