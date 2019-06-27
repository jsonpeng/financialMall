<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('题目名称');
   
            $table->integer('sort')->nullable()->comement('题目序号 越小越排在前面');

            $table->integer('paper_id')->unsigned();
            $table->foreign('paper_id')->references('id')->on('paper_lists');

            $table->index(['id', 'created_at']);
            $table->index('paper_id');

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
        Schema::drop('topics');
    }
}
