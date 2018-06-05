<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('username')->unique()->comment('用户名');
            $table->string('email')->unique()->nullable()->comment('邮箱');
            $table->string('avatar_url')->nullable()->comment('头像');
            $table->string('phone')->unique()->nullable()->comment('手机号');
            $table->string('password')->comment('密码');
            $table->text('intro')->nullable()->comment('简介');
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
        Schema::dropIfExists('users');
    }
}
