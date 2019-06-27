<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySettingTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sys_settings', 'share_intro')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->text('share_intro')->nullable()->comment('分享挣钱');
                $table->text('earn_intro')->nullable()->comment('推广挣钱');
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
        if (Schema::hasColumn('sys_settings', 'share_intro')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->dropColumn('share_intro');
                $table->dropColumn('earn_intro');
            });
        }
    }
}
