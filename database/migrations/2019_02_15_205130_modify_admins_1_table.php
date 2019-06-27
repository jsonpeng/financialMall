<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAdmins1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {

            if (!Schema::hasColumn('admins', 'image')) 
            {
                $table->string('image')->nullable()->comment('图片'); 
            }

            if (!Schema::hasColumn('admins', 'job')) 
            {
                $table->string('job')->nullable()->comment('职称'); 
            }

            if (!Schema::hasColumn('admins', 'des')) 
            {
                $table->longtext('des')->nullable()->comment('描述介绍'); 
            }

            if (!Schema::hasColumn('admins', 'fans')) 
            {
                $table->integer('fans')->nullable()->default(999)->comment('粉丝数量'); 
            }

            if (!Schema::hasColumn('admins', 'contact')) 
            {
                $table->string('contact')->nullable()->comment('联系方式'); 
            }

            if (!Schema::hasColumn('admins', 'type')) 
            {
                $table->string('type')->nullable()->default('管理员')->comment('管理员 达人'); 
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
        
    }
}
