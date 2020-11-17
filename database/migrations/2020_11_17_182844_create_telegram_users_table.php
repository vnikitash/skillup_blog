<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('telegram_id', false, true)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname')->unique();
            $table->string('lang', 2);
            $table->timestamps();
        });


        Schema::create('telegram_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('telegram_user_id', false, true);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('lang', 2);
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
        Schema::dropIfExists('teleram_users');
        Schema::dropIfExists('telegram_history');
    }
}
