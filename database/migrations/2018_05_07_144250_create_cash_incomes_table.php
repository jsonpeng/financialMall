<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCashIncomesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_incomes', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('type', ['推广收入','贷款收入','取现退款']);
            $table->float('count');
            $table->string('des')->nullable()->comment('详情');

            $table->string('custorm_name')->nullable()->comment('办理用户名称');
            $table->string('custorm_mobile')->nullable()->comment('办理用户电话');

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
        Schema::drop('cash_incomes');
    }
}
