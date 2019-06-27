<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyShareDksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('share_dks', function (Blueprint $table) {
            $table->integer('max_mount')->nullable()->default(0)->comment('最高可申请');
            $table->string('rate')->nullable()->comment('利率');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('share_dks', function (Blueprint $table) {
            $table->dropColumn('max_mount');
            $table->dropColumn('rate');
        });
    }
}
