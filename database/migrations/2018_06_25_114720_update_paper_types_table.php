<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdatePaperTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paper_types', function (Blueprint $table) {

            $table->string('image')->nullable()->comment('题库图片');

            $table->string('level')->nullable()->default('初级会员')->comment('初级会员 中级会员 高级会员');

          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
