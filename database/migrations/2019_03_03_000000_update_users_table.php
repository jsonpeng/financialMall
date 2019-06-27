<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if(!Schema::hasColumn('users', 'alipay_account')) 
            {
                $table->string('alipay_account')->nullable()->default('')->comment('支付宝账号');
            }

            if(!Schema::hasColumn('users', 'safe_code')) 
            {
                $table->string('safe_code')->nullable()->default('')->comment('安全码');
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
            if(Schema::hasColumn('users', 'alipay_account')) 
            {
                 $table->dropColumn('alipay_account');
            }
            if(Schema::hasColumn('users', 'safe_code')) 
            {
                $table->dropColumn('safe_code');
            }
        });
    }
}
