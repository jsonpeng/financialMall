<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNoticesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('公告名称');
            $table->integer('view')->nullable()->default(12)->comment('浏览量');
            $table->longtext('intro')->comment('介绍');
            $table->string('image')->nullable()->comment('图片');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'created_at' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notices');
    }
}
