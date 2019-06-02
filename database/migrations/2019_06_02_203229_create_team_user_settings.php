<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamUserSettings extends Migration
{
    public function up()
    {
        Schema::create('team_user_settings', function (Blueprint $table) {
            $table->string('team_user_id', 36)->index();
            $table->string('key')->index();
            $table->string('value');
            $table->string('type')->default('string');
            $table->timestamps();
        });
        Schema::table('team_user_settings', function (Blueprint $table) {
            $table->primary(['team_user_id', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_user_settings');
    }
}
