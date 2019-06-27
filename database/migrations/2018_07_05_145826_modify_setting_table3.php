<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySettingTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sys_settings', 'intro_text')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->text('intro_text')->nullable()->comment('首页音频文字');
                $table->text('intro_voice')->nullable()->comment('首页音频链接');
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
        if (Schema::hasColumn('sys_settings', 'intro_text')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->dropColumn('intro_text');
                $table->dropColumn('intro_voice');
            });
        }
    }
}
