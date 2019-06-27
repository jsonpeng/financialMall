<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTableLevelmoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'level_money_11')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('level_money_11')->unsigned()->nullable()->default(0)->comment('初级会员一级提成');
                $table->integer('level_money_12')->unsigned()->nullable()->default(0)->comment('初级会员二级提成');
                $table->integer('level_money_21')->unsigned()->nullable()->default(0)->comment('中级会员一级提成');
                $table->integer('level_money_22')->unsigned()->nullable()->default(0)->comment('中级会员二级提成');
                $table->integer('level_money_31')->unsigned()->nullable()->default(0)->comment('高级会员一级提成');
                $table->integer('level_money_32')->unsigned()->nullable()->default(0)->comment('高级会员二级提成');

                $table->enum('can_share', ['是','否'])->default('否')->comment('码上贷推广资格');
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
        if (Schema::hasColumn('users', 'level_money_11')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('level_money_11');
                $table->dropColumn('level_money_12');
                $table->dropColumn('level_money_21');
                $table->dropColumn('level_money_22');
                $table->dropColumn('level_money_31');
                $table->dropColumn('level_money_32');
                $table->dropColumn('can_share');
            });
        }
    }
}
