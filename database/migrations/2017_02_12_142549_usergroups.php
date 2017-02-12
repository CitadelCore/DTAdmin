<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usergroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('usergroups', function(Blueprint $table) {
          $table->increments('groupid');
          $table->string('groupname', 30);
          $table->string('directinferior', 30);
          $table->string('directsuperior', 30);
          $table->boolean('cancreateservers');
          $table->boolean('candeleteservers');
          $table->boolean('canmodifyservers');
          $table->boolean('canoverridemanager');
          $table->boolean('canmanagedtquerykey');
          $table->boolean('cancreateusers');
          $table->boolean('candeleteusers');
          $table->boolean('canmodifyusers');
          $table->boolean('caninstallplugins');
          $table->boolean('canseeallchat');
          $table->boolean('candeletechat');
          $table->boolean('canseeallmessages');
          $table->boolean('candeletemessages');
          $table->boolean('canverifyuser');
          $table->boolean('canblockip');
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
        Schema::drop('usergroups');
    }
}
