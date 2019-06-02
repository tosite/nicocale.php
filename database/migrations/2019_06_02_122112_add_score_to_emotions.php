<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreToEmotions extends Migration
{
    public function up()
    {
        Schema::table('emotions', function (Blueprint $table) {
            $table->integer('score')
                ->default(0)
                ->index('score')
                ->after('emoji')
            ;
        });
    }

    public function down()
    {
        Schema::table('emotions', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
}
