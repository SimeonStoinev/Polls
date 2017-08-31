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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->index('author_id');
            $table->text('content');
            $table->enum('type', ['message', 'invite']);
            $table->index('type');
            $table->enum('type_oftype', ['friend', 'group'])->nullable();
            $table->index('type_oftype');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
