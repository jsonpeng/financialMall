<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShareDksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_dks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_name')->comment('平台名称 微洽通');
            $table->string('channel_id')->comment('通道ID');
            $table->string('des')->nullable()->comment('描述');
            $table->string('image')->comment('图片');
            $table->string('name')->comment('名称');
            $table->enum('type', ['信用卡','贷款','彩票'])->comment('产品类型');
            $table->enum('return_type', ['固定金额','百分比'])->comment('返佣形式');
            $table->float('money_level1')->nullable()->comment('一级会员提成');
            $table->float('money_level2')->nullable()->comment('二级会员提成');
            $table->float('money_level3')->nullable()->comment('三级会员提成');
            $table->string('intro')->nullable()->comment('介绍');
            $table->integer('applied')->nullable()->comment('已申请人数');
            $table->string('share_base')->nullable()->comment('推广二维码背景图');
            $table->enum('period', ['日结','周结','月结'])->default('日结')->comment('结算周期');
            $table->integer('shelf')->default(1)->comment('上架');
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
        Schema::drop('share_dks');
    }
}
