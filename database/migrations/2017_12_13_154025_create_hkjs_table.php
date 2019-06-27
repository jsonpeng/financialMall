<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHkjsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hkjs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('黑科技名称');
            $table->longtext('intro')->comment('介绍');
            $table->string('image')->nullable()->comment('图片');
            $table->integer('view')->nullable()->default(12)->comment('浏览量');
            $table->integer('hot')->nullable()->default(0)->comment('热门');

            $table->integer('hkj_cat_id')->unsigned();
            $table->foreign('hkj_cat_id')->references('id')->on('hkj_cats');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'created_at']);
            $table->index('hkj_cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hkjs');
    }
}
