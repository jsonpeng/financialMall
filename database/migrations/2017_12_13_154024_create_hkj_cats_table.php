<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHkjCatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hkj_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('image')->nullable()->comment('图片');
            $table->integer('sort')->nullable()->comment('排序');
            $table->integer('shoufei')->nullable()->default(0)->comment('收费');
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
        Schema::drop('hkj_cats');
    }
}
