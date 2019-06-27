<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMoneyRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_records', function (Blueprint $table) {
            $table->increments('id');

            $table->float('money')->comment('金额');
            $table->string('status')->comment('状态  已完成 处理中 取消 拒绝');
            $table->string('type')->comment('类型 收入 提现 红包');
            $table->string('info')->nullable()->default('')->comment('说明信息');
            $table->string('remark')->nullable()->default('')->comment('备注');
            
            $table->string('name')->nullable()->comment('银行名称');
            $table->string('bank_name')->nullable()->comment('支行');
            $table->string('user_name')->nullable()->comment('用户名');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('count')->nullable()->comment('账号');
            $table->string('pay_no')->nullable()->comment('支付流水号');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'status', 'created_at']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('money_records');
    }
}
