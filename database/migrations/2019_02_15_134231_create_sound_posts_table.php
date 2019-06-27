<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoundPostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sound_posts', function (Blueprint $table) {

            $table->increments('id');
        
            $table->string('name')->comment('黑科技名称');
            $table->longtext('intro')->comment('介绍');
            $table->string('image')->nullable()->comment('图片');
            $table->integer('view')->nullable()->default(12)->comment('浏览量');

            $table->integer('level')->default(1)->comment('浏览权限');
            $table->string('level_name')->default('初级VIP')->nullable()->comment('浏览权限');
            $table->longtext('free_info')->nullable()->comment('介绍');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id','created_at']);
            $table->index('level_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sound_posts');
    }
}
