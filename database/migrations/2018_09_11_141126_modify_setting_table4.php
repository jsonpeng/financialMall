<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySettingTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sys_settings', 'base_share_img')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->text('base_share_img')->nullable()->comment('分享二维码底图');
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
        if (Schema::hasColumn('sys_settings', 'base_share_img')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->dropColumn('base_share_img');
            });
        }
    }
}
