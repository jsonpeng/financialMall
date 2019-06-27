<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsers2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if(!Schema::hasColumn('users', 'hongbao')) 
            {
                $table->integer('hongbao')->nullable()->default(0)->comment('用户红包余额');
            }
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if(Schema::hasColumn('users', 'hongbao')) 
            {
                 $table->dropColumn('hongbao');
            }
        });
    }
}
