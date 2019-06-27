<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySettingTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sys_settings', 'chat_link')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->text('chat_link')->nullable()->comment('在线客服链接');
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
        if (Schema::hasColumn('sys_settings', 'chat_link')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->dropColumn('chat_link');
            });
        }
    }
}
