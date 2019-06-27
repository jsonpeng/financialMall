<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShareDkRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_dk_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('terminal_id')->comment('终端ID');

            $table->integer('user_id')->nullable()->comment('推荐人ID');

            $table->string('applier_name')->nullable()->comment('用户姓名');
            $table->string('applier_mobile')->nullable()->comment('用户手机');
            $table->string('shenfenzheng')->nullable()->comment('身份证');

            $table->string('transNo')->nullable()->comment('交易号');

            $table->enum('type', ['信用卡','贷款'])->comment('产品类型');

            $table->integer('product_id')->comment('产品id');

            $table->enum('status', ['申请中','失败','已完成'])->comment('状态');

            $table->float('amount')->nullable()->comment('贷款金额');
            $table->string('shenpi')->nullable()->comment('审批');
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
        Schema::drop('share_dk_records');
    }
}
