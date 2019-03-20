<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiPrimaryKeyToSubTeamUsers extends Migration
{
    public function up()
    {
        Schema::table('sub_team_users', function (Blueprint $table) {
            $table->primary(['team_user_id', 'sub_team_id']);
        });
    }

    public function down()
    {
        Schema::table('sub_team_users', function (Blueprint $table) {
            //
        });
    }
}
