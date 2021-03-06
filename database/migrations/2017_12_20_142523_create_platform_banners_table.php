<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlatformBannersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->comment('图片');
            $table->string('link')->nullable()->comment('链接');
            $table->integer('sort')->nullable()->comment('排序');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'sort']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('platform_banners');
    }
}
