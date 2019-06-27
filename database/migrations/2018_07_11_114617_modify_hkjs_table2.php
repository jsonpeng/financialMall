<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyHkjsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('hkjs', 'level')) {
            Schema::table('hkjs', function (Blueprint $table) {
                $table->integer('level')->default(1)->comment('浏览权限');
                $table->string('level_name')->default('初级VIP')->nullable()->comment('浏览权限');
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
        if (Schema::hasColumn('hkjs', 'level')) {
            Schema::table('hkjs', function (Blueprint $table) {
                 $table->dropColumn('level');
                 $table->dropColumn('level_name');
            });
        }
    }
}
