<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoundPostCatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sound_post_cats', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('系列分类名称');

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
        Schema::drop('sound_post_cats');
    }
}
