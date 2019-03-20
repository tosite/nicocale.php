<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubTeamUsers extends Migration
{

    public function up()
    {
        Schema::create('sub_team_users', function (Blueprint $table) {
            $table->string('id', 36)->index();
            $table->string('user_id', 36)->index();
            $table->string('team_id', 36)->index();
            $table->string('team_user_id', 36)->index();
            $table->string('sub_team_id', 36)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_team_users');
    }
}
