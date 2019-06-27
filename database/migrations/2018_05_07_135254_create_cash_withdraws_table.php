<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCashWithdrawsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_withdraws', function (Blueprint $table) {
            $table->increments('id');

            $table->float('count')->default(0)->comment('提取金额');
            $table->string('name')->comment('用户姓名');
            $table->string('zhifubao')->comment('支付宝账号');
            $table->enum('status', ['待审核','审核通过','审核不通过','失败'])->string('status');
            $table->string('trade_no')->nullable()->comment('交易号');
            $table->string('out_trade_no')->nullable()->comment('商户号');
            $table->string('reason')->nullable()->comment('管理员回复');
            $table->timestamp('operate_time')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('cash_withdraws');
    }
}
