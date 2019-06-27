<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJifenRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jifen_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('oemChannelId');
            $table->string('clientNo');
            $table->string('channelTagId');
            $table->string('content');
            $table->string('type');
            $table->string('bank')->nullable()->comment('银行');
            $table->string('title')->nullable()->comment('兑换物品');
            $table->float('money_all')->nullable()->default(0)->comment('平台返总金额');
            $table->float('money_user')->nullable()->default(0)->comment('用户获得金额');
            $table->float('money_level1')->nullable()->default(0)->comment('一级推荐人分佣');
            $table->float('money_level2')->nullable()->default(0)->comment('二级推荐人分佣');

            $table->string('kefu')->nullable()->comment('客服微信二维码');
            $table->string('transNo')->nullable()->comment('交易号');

            $table->integer('user_id')->nullable()->comment('兑换用户ID');
            $table->enum('status', ['申请中','失败','已完成'])->comment('状态');

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
        Schema::drop('jifen_records');
    }
}
