<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyHkjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('hkjs', 'free_info')) {
            Schema::table('hkjs', function (Blueprint $table) {
                $table->longtext('free_info')->nullable()->comment('介绍');
                $table->enum('free', ['是','否'])->default('否')->comment('产品类型');
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
        if (Schema::hasColumn('hkjs', 'free_info')) {
            Schema::table('hkjs', function (Blueprint $table) {
                $table->dropColumn('free_info');
                 $table->dropColumn('free');
            });
        }
    }
}
