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
            $table->increments('id');
            $table->string('name')->nullable()->default('')->comment('登录名');
            $table->string('email')->nullable();
            $table->string('password')->default('123456');
            $table->string('mobile')->nullable();
            $table->string('share_image')->nullable();
            $table->string('header')->nullable()->default('')->comment('用户头像');
            $table->string('nickname')->nullable()->default('')->comment('昵称');
            $table->string('openid')->nullable()->default('')->comment('openid');
            $table->string('level')->nullable()->default('用户')->comment('用户角色');
            $table->string('status')->nullable()->default('正常')->comment('账户状态');
            $table->integer('parent_id')->nullable()->default(0)->comment('上级ID');
            $table->integer('sex')->nullable()->default(0)->comment('用户性别');
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->tinyInteger('member')->default(0)->comment('会员状态 0 非会员 1 会员');
            $table->timestamp('member_buy_time')->nullable();
            $table->timestamp('member_end_time')->nullable();

            $table->float('money')->default(0)->comment('剩余佣金');
            $table->float('money_all')->default(0)->comment('总佣金');

            $table->float('credit')->default(0)->comment('剩余积分');
            $table->float('credit_all')->default(0)->comment('总积分');

            $table->integer('scale')->nullable()->comment('提成比例');
            $table->integer('scale_level2')->nullable()->comment('提成比例_二级');


            $table->rememberToken();
            $table->timestamps();

            $table->index(['id', 'created_at', 'member']);
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
