<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMiddleLevelInfosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('middle_level_infos', function (Blueprint $table) {

            if(!Schema::hasColumn('middle_level_infos', 'all_count_time')) 
            {
                $table->string('all_count_time')->nullable()->comment('总时长');
            }

            if(!Schema::hasColumn('middle_level_infos', 'jifen')) 
            {
                 $table->integer('jifen')->nullable()->default(0)->comment('观看完成赠送积分');
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
        if (Schema::hasColumn('middle_level_infos', 'all_count_time')) 
        {
            Schema::table('middle_level_infos', function (Blueprint $table) {
                 $table->dropColumn('all_count_time');
            });
        }

        if (Schema::hasColumn('middle_level_infos', 'jifen')) 
        {
            Schema::table('middle_level_infos', function (Blueprint $table) {
                 $table->dropColumn('jifen');
            });
        }

    }
}
