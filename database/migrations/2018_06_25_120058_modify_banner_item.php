<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBannerItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('banner_items', 'page_name')) {
            Schema::table('banner_items', function (Blueprint $table) {

                $table->text('page_name')->nullable()->comment('页面');
                $table->text('name')->nullable()->comment('页面名称');
                $table->integer('page_id')->nullable()->comment('页面ID');


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
        if (Schema::hasColumn('banner_items', 'page_name')) {
            Schema::table('banner_items', function (Blueprint $table) {
                $table->dropColumn('page_name');
                $table->dropColumn('name');
                $table->dropColumn('page_id');   
            });
        }         
    }
}
