<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLevelSoundsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_sounds', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('level_info_id')->unsigned();
            $table->foreign('level_info_id')->references('id')->on('middle_level_infos');

            $table->integer('sound_post_id')->unsigned();
            $table->foreign('sound_post_id')->references('id')->on('sound_posts');

            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('level_sounds');
    }
}
