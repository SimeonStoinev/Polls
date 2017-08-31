<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->index('user_id');
            $table->integer('group_id');
            $table->index('group_id');
            $table->enum('status', ['active', 'banned', 'left', 'pending']);
            $table->index('status');
            $table->enum('rank', ['owner', 'admin', 'member']);
            $table->index('rank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_members');
    }
}
