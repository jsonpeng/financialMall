<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToolCatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tools', 'cat_id')) {
            Schema::table('tools', function (Blueprint $table) {
                $table->integer('cat_id')->nullable()->default(0)->comment('分类');
            });
        }

        Schema::create('tool_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('sort');
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
        Schema::drop('tool_cats');

        if (Schema::hasColumn('tools', 'cat_id')) {
            Schema::table('tools', function (Blueprint $table) {
                 $table->dropColumn('cat_id');
            });
        }
        
    }
}
