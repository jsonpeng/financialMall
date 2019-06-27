<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'mem_level')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('mem_level')->unsigned()->default(1)->comment('会员等级');
            });

            Schema::table('user_levels', function (Blueprint $table) {
                $table->integer('level')->unsigned()->default(1)->comment('会员等级');
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
        if (Schema::hasColumn('users', 'mem_level')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('mem_level');
            });

            Schema::table('user_levels', function (Blueprint $table) {
                $table->dropColumn('level');
            });
        }
    }
}
