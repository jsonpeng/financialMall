<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'level_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('level_name', 50)->nullable()->default('');
                $table->integer('level_id')->nullable();
                $table->integer('member_buy_money')->nullable();
            });
        }
        
        if (!Schema::hasColumn('old_orders', 'level_name')) {
            Schema::table('old_orders', function (Blueprint $table) {
                $table->string('level_name', 50)->nullable()->default('');
                $table->integer('level_id')->nullable();
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
        if (Schema::hasColumn('users', 'level_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('level_name');
                $table->dropColumn('level_id');
                $table->dropColumn('member_buy_money');
            });
        }

        if (Schema::hasColumn('orders', 'level_name')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('level_name');
                $table->dropColumn('level_id');
            });
        }
    }
}
