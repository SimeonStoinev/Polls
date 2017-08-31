<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SentMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id');
            $table->index('message_id');
            $table->integer('members_id');
            $table->index('members_id');
            $table->boolean('read_flag')->nullable();
            $table->index('read_flag');
            $table->enum('invite_flag', ['accepted', 'declined', 'pending', 'none'])->nullable();
            $table->index('invite_flag');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sent_messages');
    }
}
