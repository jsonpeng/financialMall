<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoundPostUserLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sound_post_user_logs', function (Blueprint $table) {
            $table->increments('id');
           
            $table->string('last_see_time')->comment('上次观看时间');
            $table->integer('whether_end')->nullable()->comment('是否已经看完获取过积分');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('sound_post_id')->unsigned();
            $table->foreign('sound_post_id')->references('id')->on('middle_level_infos');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id','created_at']);
            $table->index('user_id');
            $table->index('sound_post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sound_post_user_logs');
    }
}
