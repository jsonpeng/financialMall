<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateLevelsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
      

            $table->integer('level1')->nullable()->default(0)->comment('一级会员卡提成');

            $table->integer('level2')->nullable()->default(0)->comment('二级会员卡提成');

            $table->integer('level3')->nullable()->default(0)->comment('三级会员卡提成');

            $table->integer('level_more')->nullable()->default(0)->comment('更高级会员卡提成');

         
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
