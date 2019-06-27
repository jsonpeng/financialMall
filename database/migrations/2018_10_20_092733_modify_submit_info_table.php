<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySubmitInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('submit_info_logs', 'shenfenzheng')) {
            Schema::table('submit_info_logs', function (Blueprint $table) {
                $table->text('shenfenzheng')->nullable()->comment('身份证');
                $table->text('sex')->nullable()->comment('性别');
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
        if (Schema::hasColumn('submit_info_logs', 'shenfenzheng')) {
            Schema::table('submit_info_logs', function (Blueprint $table) {
                $table->dropColumn('shenfenzheng');
                $table->dropColumn('sex');
            });
        }
    }
}
