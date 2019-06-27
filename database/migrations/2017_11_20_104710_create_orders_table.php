<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->float('money')->comment('金额');
            $table->string('pay_no')->comment('交流流水');
            $table->string('platform')->nullable()->comment('交易平台 微信 支付宝');
            $table->string('pay_status')->comment('支付状态 未支付 已支付');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'pay_status', 'created_at']);
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
        Schema::drop('orders');
    }
}
