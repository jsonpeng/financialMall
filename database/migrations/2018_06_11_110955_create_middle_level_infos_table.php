<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMiddleLevelInfosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('middle_level_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('des')->comment('描述');
            $table->string('image')->comment('图片');
            $table->enum('type', ['语音','视频'])->comment('类型');
            $table->integer('view')->default(0)->nullbale()->comment('浏览量');
            $table->string('link')->comment('链接');
            $table->longtext('intro')->nullable()->comment('正文说明');
            $table->string('level')->comment('中级会员 高级会员');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('middle_level_infos');
    }
}
