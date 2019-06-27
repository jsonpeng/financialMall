<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubmitInfoLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submit_info_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->comment('手机号');
            $table->enum('whether_mobile_lg_half_year',['是','否'])->comment('电话是否半年以上 是/否');
            $table->enum('whether_shimingzhi',['是','否'])->comment('是否实名制  是/否');
            $table->integer('age')->comment('年龄');
            $table->string('whether_has_xycard')->comment('有无信用卡[几张]');
            $table->enum('whether_normal_use',['是','否'])->comment('是否正常使用');
            $table->enum('whether_has_delay',['有','无'])->comment('有无逾期');
            $table->enum('whether_give_xycard_log',['是','否'])->comment('是否能提供信用卡账单邮箱6个月以上');
            $table->integer('zhimafen')->comment('芝麻分多少');
            $table->enum('whether_is_wanghei',['是','否'])->comment('是否是网黑');
            $table->enum('whether_wangdai',['有','无'])->comment('最近有无频繁网贷');
            $table->enum('whether_had_job',['有','无'])->comment('有无稳定工作');
            $table->enum('whether_has_shebao',['有','无'])->comment('有无社保');
            $table->enum('whether_has_gongjijin',['有','无'])->comment('有无公积金');
            $table->enum('whether_is_student',['是','否'])->comment('是否是学生');
            $table->enum('whether_has_xuexinwang',['是','否'])->comment('学信网是否能查到吗');
            $table->enum('whether_know_dk',['是','否'])->comment('DK事项和流程是否了解');

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
        Schema::drop('submit_info_logs');
    }
}
