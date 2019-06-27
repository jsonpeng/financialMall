<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPlatFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('plat_forms', 'sort')) {
            Schema::table('plat_forms', function (Blueprint $table) {
                $table->integer('sort')->nullable()->default(1)->comment('排序权重');
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
        if (Schema::hasColumn('plat_forms', 'sort')) {
            Schema::table('plat_forms', function (Blueprint $table) {
                 $table->dropColumn('sort');
            });
        }
    }
}
