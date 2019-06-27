<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyToolCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tool_cats', 'slug')) {
            Schema::table('tool_cats', function (Blueprint $table) {
                $table->text('slug')->nullable()->comment('别名');
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
        if (Schema::hasColumn('tool_cats', 'base_share_img')) {
            Schema::table('tool_cats', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
}
