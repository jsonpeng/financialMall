<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductLevelPricesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_level_prices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->comment('商品id/规格id');
            $table->enum('type',['product','spec'])->comment('普通商品/带有规格的商品');
            $table->float('price')->default(0)->comment('会员价格');

            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('user_levels');
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id','created_at']);
            $table->index('type');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_level_prices');
    }
}
