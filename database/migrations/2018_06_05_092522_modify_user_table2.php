<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'leader1')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('leader1')->unsigned()->nullable()->default(0)->comment('一级推荐人');
                $table->integer('leader2')->unsigned()->nullable()->default(0)->comment('二级推荐人');
                $table->integer('leader3')->unsigned()->nullable()->default(0)->comment('三级推荐人');

                $table->integer('level1')->unsigned()->default(0)->comment('一级下线数');
                $table->integer('level2')->unsigned()->default(0)->comment('二级下线数');
                $table->integer('level3')->unsigned()->default(0)->comment('三级下线数');

                $table->string('share_code')->nullable();
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
        if (Schema::hasColumn('users', 'leader1')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('leader1');
                $table->dropColumn('leader2');
                $table->dropColumn('leader3');

                $table->dropColumn('level1');
                $table->dropColumn('level2');
                $table->dropColumn('level3');

                $table->dropColumn('share_code');
            });
        }

    }
}
