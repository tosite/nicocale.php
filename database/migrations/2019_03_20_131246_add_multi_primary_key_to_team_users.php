<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiPrimaryKeyToTeamUsers extends Migration
{
    public function up()
    {
        Schema::table('team_users', function (Blueprint $table) {
            $table->primary(['user_id', 'team_id']);
        });
    }

    public function down()
    {
        Schema::table('team_users', function (Blueprint $table) {
            //
        });
    }
}
