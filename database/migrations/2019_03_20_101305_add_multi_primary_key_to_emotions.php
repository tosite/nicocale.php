<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiPrimaryKeyToEmotions extends Migration
{
    public function up()
    {
        Schema::table('emotions', function (Blueprint $table) {
            $table->primary(['team_user_id', 'entered_on']);
        });
    }

    public function down()
    {
        Schema::table('emotions', function (Blueprint $table) {
            //
        });
    }
}
