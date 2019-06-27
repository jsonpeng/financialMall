<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateSpinResultsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spin_results', function (Blueprint $table) {

            $table->string('name')->nullable()->comment('奖品名称');

            $table->string('rec_name')->nullable()->comment('收货人姓名');
            $table->string('rec_mobile')->nullable()->comment('收货人联系方式');
            $table->string('rec_address')->nullable()->comment('收货人地址');

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
