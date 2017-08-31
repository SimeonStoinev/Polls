<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->string('answers');
            $table->integer('creator_id');
            $table->enum('status', ['active', 'closed', 'banned', 'draft']);
            $table->index('status');
            $table->enum('for_users', ['public', 'all', 'group', 'private']);
            $table->index('for_users');
            $table->string('slug')->nullable();
            $table->index('slug');
            $table->timestamps();
        });

        DB::table('pools')->insert( [
            'question' => 'Кой е най-добрият футболист?',
            'answers' => '["Роналдо","Меси","Бейл"]',
            'creator_id' => '2',
            'status' => 'active',
            'for_users' => 'all',
            'slug' => '06-03-2017-2-zXG3CiguL5PbqdYEwmpZz4BAwDbikNnl'
        ]);
        DB::table('pools')->insert( [
            'question' => 'Кой да поканя на рождения си ден?',
            'answers' => '["Пешо","Гошо","Иван","Митко"]',
            'creator_id' => '2',
            'status' => 'active',
            'for_users' => 'all',
            'slug' => '06-03-2017-2-2jUFlgDWckyyhWm8Ia3DzHz5NBtHIZaU'
        ]);
        DB::table('pools')->insert( [
            'question' => 'Какъв цвят да ми е колата?',
            'answers' => '["Синя","Червена"]',
            'creator_id' => '3',
            'status' => 'active',
            'for_users' => 'all',
            'slug' => '06-03-2017-3-zxyrWapNIgbUJlDtU8I1wyhyhNNdJCnM'
        ]);
        DB::table('pools')->insert( [
            'question' => 'Какъв алкохол да има в повече на купона?',
            'answers' => '["Уиски","Ракия","Вино","Водка","Бира"]',
            'creator_id' => '3',
            'status' => 'active',
            'for_users' => 'all',
            'slug' => '06-03-2017-3-8mA9wQopagt1mkzMV9Vqwjiy14SRHSKO'
        ]);
        DB::table('pools')->insert( [
            'question' => 'Коя е най-добрата игра на Близард?',
            'answers' => '["StarCraft","WarCraft","Diablo"]',
            'creator_id' => '5',
            'status' => 'active',
            'for_users' => 'all',
            'slug' => '06-03-2017-5-E1GPdP8l109LLZ3xGW5iNapa96tEitBj'
        ]);
        DB::table('pools')->insert( [
            'question' => 'До кое ниво на Английски език се учи в училище?',
            'answers' => '["B2","B2+"]',
            'creator_id' => '5',
            'status' => 'active',
            'for_users' => 'all',
            'slug' => '06-03-2017-5-GYoaqMl5RQR9NR6034zyC2Np05AaYY4Z'
        ]);
        DB::table('pools')->insert( [
            'question' => 'Who will win in the next FIVB France vs Italy match??',
            'answers' => '["France 3:0 Italy","France 3:1 Italy","France 3:2 Italy","France 2:3 Italy","France 1:3 Italy","France 0:3 Italy"]',
            'creator_id' => '2',
            'status' => 'active',
            'for_users' => 'public',
            'slug' => '06-03-2017-2-jgRNcm9fqmx2TWtg0knJ3YwVyhAyyiZG'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pools');
    }
}
