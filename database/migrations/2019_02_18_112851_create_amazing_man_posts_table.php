<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAmazingManPostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazing_man_posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');

            $table->integer('post_id')->comment('关联模型文章id');

            $table->string('type')->comment('类型 soundPost/hkj');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id','created_at']);
            $table->index('admin_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amazing_man_posts');
    }
}
