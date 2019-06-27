<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySettingTable6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sys_settings', 'tishi')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->text('tishi')->nullable()->comment('温馨提示');
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
        if (Schema::hasColumn('sys_settings', 'tishi')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->dropColumn('tishi');
            });
        }
    }
}
