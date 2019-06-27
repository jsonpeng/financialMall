<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSelectionsTopicsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selections_topics', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type')->default('A')->comment('ABCDEFGHIJK');
            $table->string('content')->nullable()->comment('内容');

            $table->integer('is_result')->nullable()->default(0)->comment('是否是答案0不是1是');

            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics');

            $table->index(['id', 'created_at']);
            $table->index('topic_id');

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
        Schema::drop('selections_topics');
    }
}
