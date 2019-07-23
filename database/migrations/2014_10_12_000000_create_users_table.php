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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username');
            $table->string('phone')->nullable()->unique();
            $table->string('weapp_openid')->nullable()->comment('微信开放id');
            $table->string('weapp_avatar')->nullable()->comment('微信头像');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('weapp_session_key')->nullable()->comment('微信session_key');
            $table->string('country')->nullable()->comment('国家');
            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('所在城市');
            $table->string('language')->nullable()->comment('语言');
            $table->json('location')->nullable()->comment('当前地理信息');
            $table->enum('gender', ['1', '2'])->default('1')->comment('性别默认男');
            $table->integer('level')->default('1')->comment('用户等级 1 2 3 4');
            $table->integer('is_admin')->default('0')->comment('0 否 1 是');
            $table->rememberToken();
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
