<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_records', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('paper_id')->unsigned();
            $table->foreign('paper_id')->references('id')->on('paper_lists');

            $table->integer('paper_type_id')->unsigned();
            $table->foreign('paper_type_id')->references('id')->on('paper_types');
          
            $table->integer('topic_num')->comment('答题数');

            $table->integer('is_pass')->nullable()->default(0)->comment('是否通过0未通过1通过');

            $table->integer('grade')->comment('成绩');

            $table->index(['id', 'created_at']);
            $table->index('user_id');
            $table->index('paper_id');
            $table->index('paper_type_id');

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
        Schema::drop('test_records');
    }
}
