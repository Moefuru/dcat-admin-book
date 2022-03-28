<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nick_name')->default('')->comment('昵称');
            $table->string('head_portrait')->default('')->comment('头像');
            $table->string('phone')->default('')->comment('手机号');
            $table->tinyInteger('platform')->comment('平台');
            $table->string('last_token')->default('')->comment('最后登录token');
            $table->timestamp('last_login_time')->comment('最后登录时间');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user');
    }
}
