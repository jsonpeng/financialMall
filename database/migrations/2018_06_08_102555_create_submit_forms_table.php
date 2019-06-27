<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubmitFormsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submit_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->nullable()->comment('用户姓名');
            $table->string('mobile')->comment('电话');
            $table->string('province')->nullable()->comment('省');
            $table->string('city')->nullable()->comment('市');
            $table->string('district')->nullable()->comment('区');
            $table->string('message')->nullable()->comment('留言');
            $table->string('extro')->nullable()->comment('额外消息');
            $table->string('type')->comment('类型');
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
        Schema::drop('submit_forms');
    }
}
