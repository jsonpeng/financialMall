<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sys_settings', 'min_cash')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->integer('min_cash')->default(100)->comment('最低提取金额');
                $table->integer('max_cash_withdraw')->default(2)->comment('每月最多提取次数');

                $table->text('logo')->nullable()->comment('LOGO');
                $table->text('apk_link')->nullable()->comment('安卓下载地址');
                $table->text('ios_link')->nullable()->comment('苹果下载地址');

                $table->longtext('law_sale')->nullable()->comment('购买协议');
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
        if (Schema::hasColumn('sys_settings', 'min_cash')) {
            Schema::table('sys_settings', function (Blueprint $table) {
                $table->dropColumn('min_cash');
                $table->dropColumn('max_cash_withdraw');
                $table->dropColumn('logo');
                $table->dropColumn('apk_link');
                $table->dropColumn('ios_link');
                $table->dropColumn('law_sale');
            });
        }
    }
}
