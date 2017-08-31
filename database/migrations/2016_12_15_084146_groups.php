<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Groups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('creator_id');
            $table->index('creator_id');
            $table->string('thumbnail')->nullable();
            $table->string('slug')->nullable();
            $table->enum('category', ['news', 'school', 'work', 'entertainment', 'celebrities', 'politics', 'business', 'music', 'others']);
            $table->index('category');
            $table->enum('status', ['active', 'banned', 'closed', 'pending']);
            $table->index('status');
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
        Schema::dropIfExists('groups');
    }
}
