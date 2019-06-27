<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlatFormsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plat_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('brief')->nullable()->comment('简介');
            $table->string('image')->comment('图片');
            $table->integer('star')->nullable()->default(5)->comment('评级');
            $table->string('remark')->nullable()->default('')->comment('备注，以分号分割');
            $table->integer('view')->nullable()->default(10000)->comment('浏览量');
            $table->string('jiehao')->nullable()->default('')->comment('介绍');
            $table->string('tiaojian')->nullable()->default('')->comment('申请条件');
            $table->string('cailiao')->nullable()->default('')->comment('申请材料');
            $table->string('link')->comment('链接');
            $table->integer('hot')->nullable()->default(0)->comment('热门');
            $table->integer('edu_min')->nullable()->default(0)->comment('最低额度');
            $table->integer('edu_max')->nullable()->default(0)->comment('最高额度');
            $table->string('time')->nullable()->default('日')->comment('贷款周期 日 月');
            $table->integer('time_min')->nullable()->default(1)->comment('最小周期');
            $table->integer('time_max')->nullable()->default(30)->comment('最大周期');
            $table->float('rate')->nullable()->default(0)->comment('利率(%)');
            $table->string('fangkuan')->nullable()->default('当天放款')->comment('放款时间');

            $table->integer('plat_form_cat_id')->unsigned();
            $table->foreign('plat_form_cat_id')->references('id')->on('plat_form_cats');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'hot', 'created_at']);
            $table->index('plat_form_cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plat_forms');
    }
}
