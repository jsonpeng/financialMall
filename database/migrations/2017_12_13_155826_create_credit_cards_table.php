<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditCardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('排序');
            $table->string('brief')->nullable()->default('')->comment('简介 ');
            $table->string('image')->comment('图片');
            $table->integer('view')->nullable()->default(10000)->comment('浏览量');
            $table->string('remark')->nullable()->default('')->comment('特点，分号分割');
            $table->string('link')->comment('链接');
            $table->integer('hot')->nullable()->default(0)->comment('热门');

            $table->integer('credit_card_bank_id')->unsigned();
            $table->foreign('credit_card_bank_id')->references('id')->on('credit_card_banks');

            $table->integer('credit_card_theme_id')->unsigned();
            $table->foreign('credit_card_theme_id')->references('id')->on('credit_card_themes');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'hot', 'created_at']);
            $table->index('credit_card_bank_id');
            $table->index('credit_card_theme_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('credit_cards');
    }
}
