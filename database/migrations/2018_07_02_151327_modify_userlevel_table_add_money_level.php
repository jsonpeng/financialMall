<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserlevelTableAddMoneyLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('user_levels', 'level_money_11')) {
            Schema::table('user_levels', function (Blueprint $table) {
                $table->integer('level_money_11')->unsigned()->nullable()->default(0)->comment('一级提成');
                $table->integer('level_money_12')->unsigned()->nullable()->default(0)->comment('二级提成');
                // $table->integer('level_money_21')->unsigned()->nullable()->default(0)->comment('中级会员一级提成');
                // $table->integer('level_money_22')->unsigned()->nullable()->default(0)->comment('中级会员二级提成');
                // $table->integer('level_money_31')->unsigned()->nullable()->default(0)->comment('高级会员一级提成');
                // $table->integer('level_money_32')->unsigned()->nullable()->default(0)->comment('高级会员二级提成');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_levels', 'level_money_11')) {
            Schema::table('user_levels', function (Blueprint $table) {
                $table->dropColumn('level_money_11');
                $table->dropColumn('level_money_12');
                // $table->dropColumn('level_money_21');
                // $table->dropColumn('level_money_22');
                // $table->dropColumn('level_money_31');
                // $table->dropColumn('level_money_32');
            });
        }
    }
}
