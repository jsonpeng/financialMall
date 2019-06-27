<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMiddleLevelInfos2Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('middle_level_infos', function (Blueprint $table) {

            if(!Schema::hasColumn('middle_level_infos', 'cat_id')) 
            {
                $table->string('cat_id')->nullable()->default(0)->comment('分类id');
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
        if (Schema::hasColumn('middle_level_infos', 'cat_id')) 
        {
            Schema::table('middle_level_infos', function (Blueprint $table) {
                 $table->dropColumn('cat_id');
            });
        }

    }
}
