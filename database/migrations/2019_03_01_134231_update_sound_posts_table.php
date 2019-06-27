<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateSoundPostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('sound_posts', 'cat_id')) 
        {
            Schema::table('sound_posts', function (Blueprint $table) 
            {
                $table->integer('cat_id')->nullable()->default(0)->comment('系列分类id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if(Schema::hasColumn('sound_posts', 'cat_id')) 
      {
            Schema::table('sound_posts', function (Blueprint $table) 
            {
                 $table->dropColumn('cat_id');
            });
      }
    }
}
