<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateLevels2Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
      

            $table->integer('level1_1')->nullable()->default(0)->comment('一级会员卡一级提成');

            $table->integer('level1_2')->nullable()->default(0)->comment('一级会员卡二级提成');


            $table->integer('level2_1')->nullable()->default(0)->comment('二级会员卡一级提成');

            $table->integer('level2_2')->nullable()->default(0)->comment('二级会员卡二级提成');
         
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
