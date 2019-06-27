<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('user_levels', 'attach_words')) {
            Schema::table('user_levels', function (Blueprint $table) {
                $table->longtext('attach_words')->nullable()->comment('会员权益');
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
        if (Schema::hasColumn('user_levels', 'attach_words')) {
            Schema::table('user_levels', function (Blueprint $table) {
                $table->dropColumn('attach_words');
            });
        }
    }
}
