<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->longText('friends')->nullable();
            //{"1","20"} like = "%\"20\"%"
            // json_decode(JSON,true)  -- true vrushta array;
            // in_array()
            $table->string('confirmToken', 32);
            $table->index('confirmToken');
            $table->string('unsubToken', 32)->nullable();
            $table->index('unsubToken');
            $table->string('thumbnail')->nullable();
            $table->index('thumbnail');
            $table->enum('status', ['active', 'banned', 'pending']);
            $table->index('status');
            $table->enum('rank', ['owner', 'admin', 'member']);
            $table->timestamps();
        });


        DB::table('users')->insert( [
            'name' => 'Owner',
            'email' => 'l70etc@abv.bg',
            'password' => '$2y$10$2kFKJUkchnUzFhY24BL9v.RPC33qfZTxSrMze5nGJ3C3lFnqJOE3K',
            'confirmToken' => '',
            'status' => 'active',
            'rank' => 'owner'
        ]);
        DB::table('users')->insert( [
            'name' => 'test',
            'email' => 'test@abv.bg',
            'password' => '$2y$10$AF3kc.Xc.nuibn831IDVBejgwA4HZYO6T7MxQenGACsndXgOrDKr.',
            'confirmToken'  => '',
            'status' => 'active',
            'rank' => 'member'
        ]);
        DB::table('users')->insert( [
            'name' => 'novuser',
            'email' => 'novuser@abv.bg',
            'password' => '$2y$10$2F59IpV6ckvOnHFycv/TB.7O9tI93Bp1PKZ.ZYoQu0GvhoX.lC14a',
            'confirmToken'  => '',
            'status' => 'active',
            'rank' => 'member'
        ]);
        DB::table('users')->insert( [
            'name' => 'newone',
            'email' => 'newone@abv.bg',
            'password' => '$2y$10$ydSDRa6GZzyC4hUfV7OsKejkA1sRJ3N3HCFefAtqKthtdRJ6kNpTW',
            'confirmToken'  => '',
            'status' => 'active',
            'rank' => 'member'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
