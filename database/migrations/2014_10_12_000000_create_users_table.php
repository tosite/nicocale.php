<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 36)->index();
            $table->string('name');
            $table->string('slack_token')->unique();
            $table->string('slack_user_id')->primary();
            $table->string('avatar');
            $table->string('bio')->default('')->nullable();
            $table->string('emoji_set')->default('apple');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('users');
    }
}
