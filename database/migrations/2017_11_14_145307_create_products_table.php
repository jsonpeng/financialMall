<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('image')->comment('图片');
            $table->float('price')->default(168)->comment('销售价格');
            $table->string('des')->nullable()->comment('小字描述');
            $table->integer('sales')->default(3524)->comment('销售数量');
            $table->longtext('intro')->nullable()->comment('说明信息');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
