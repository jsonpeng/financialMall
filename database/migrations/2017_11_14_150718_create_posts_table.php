<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('文章名称');
            $table->integer('view')->default(12)->comment('浏览量');
            $table->longtext('intro')->comment('详情介绍');

            $table->string('image')->nullable()->comment('图片');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('post_categories');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'created_at']);
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
