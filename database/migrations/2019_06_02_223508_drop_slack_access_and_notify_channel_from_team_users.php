<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSlackAccessAndNotifyChannelFromTeamUsers extends Migration
{
    public function up()
    {
        Schema::table('team_users', function (Blueprint $table) {
            $table->dropColumn('slack_access');
            $table->dropColumn('notify_channel');
        });
    }

    public function down()
    {
        Schema::table('team_users', function (Blueprint $table) {
            //
        });
    }
}
