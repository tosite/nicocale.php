<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubTeamUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_team_users', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('team_id', 36)->index();
            $table->string('team_user_id', 36)->index();
            $table->string('sub_team_id', 36)->index();
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
        Schema::dropIfExists('sub_team_users');
    }
}
