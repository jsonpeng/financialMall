<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateComplaintLogsTable1 extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint_logs', function (Blueprint $table) {
   
            $table->string('commit')->nullable()->comment('联系方式');

            $table->string('image1')->nullable()->comment('反馈图1 链接');
            $table->string('image2')->nullable()->comment('反馈图2 链接');
            $table->string('image3')->nullable()->comment('反馈图3 链接');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
