<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyItems2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('items', 'user_id')) {
            Schema::table('items', function (Blueprint $table) 
            {
                $table->integer('user_id')->comment('加入用户编号');
                $table->index('user_id');
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
        if (Schema::hasColumn('items', 'user_id')) {
            Schema::table('items', function (Blueprint $table) 
            {
                 $table->dropColumn('user_id');
            });
        }
    }
}
