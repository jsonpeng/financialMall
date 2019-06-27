<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyToolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tools', 'mobile')) {
            Schema::table('tools', function (Blueprint $table) {
                $table->text('mobile')->nullable()->comment('联系电话');
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
        if (Schema::hasColumn('tools', 'mobile')) {
            Schema::table('tools', function (Blueprint $table) {
                 $table->dropColumn('mobile');
            });
        }
    }
}
