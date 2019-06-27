<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHongBaoLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hong_bao_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['收入','支出']);
            $table->integer('count')->comment('金额');
            $table->string('des')->nullable()->comment('详情');
            $table->enum('status', ['已通过', '驳回', '待审核'])->default('待审核')->comment('如果驳回将扣除积分');
            $table->string('reason')->nullable()->comment('驳回原因');
            $table->string('order_no')->comment('单号');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('ali_name')->nullable()->comment('支付宝账号名称');
            $table->string('ali_account')->nullable()->comment('支付宝账号');
            $table->string('trade_no')->nullable()->comment('支付宝平台交易号');
            $table->string('out_trade_no')->nullable()->comment('第三方平台交易号');
            $table->timestamp('operation_time')->nullable()->comment('提现时间');
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
        Schema::drop('hong_bao_logs');
    }
}
