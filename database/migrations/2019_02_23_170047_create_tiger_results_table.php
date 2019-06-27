<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTigerResultsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiger_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('coin_in');
            $table->integer('coin_out');
            $table->integer('result');
            $table->string('account')->nullable();
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
        Schema::drop('tiger_results');
    }
}
