<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaperListsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('试卷名称');
            $table->string('level')->nullable()->default('一级')->comment('难度等级');

            $table->integer('pass_grade')->nullable()->default('60')->comment('及格通过分数');

            $table->integer('paper_type_id')->unsigned();
            $table->foreign('paper_type_id')->references('id')->on('paper_types');

            $table->index(['id', 'created_at']);
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
        Schema::drop('paper_lists');
    }
}
