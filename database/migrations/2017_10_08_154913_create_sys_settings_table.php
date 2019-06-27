<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSysSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('intro')->nullable()->comment('关于我们');
            $table->longtext('daili')->nullable()->comment('代理介绍');
            $table->longtext('share_content')->nullable()->comment('分享的页面内容');
            $table->string('name')->nullable()->default('')->comment('网站名称');
            $table->integer('scale')->nullable()->default(10)->comment('提成比例');
            $table->integer('scale_level2')->nullable()->default(0)->comment('二级提成比例');
            $table->integer('post_per_page')->nullable()->default(15)->comment('后台每页显示文章数目');

            $table->integer('shoufei_xinyongka')->nullable()->default(1)->comment('信用卡收费');
            $table->integer('shoufei_jieqian')->nullable()->default(1)->comment('借钱收费');

            $table->longtext('law')->nullable()->comment('服务协议');

            $table->string('sms_id')->nullable()->default('')->comment('短信发送配置');
            $table->string('sms_key')->nullable()->default('')->comment('短信发送配置');
            $table->string('sms_sign')->nullable()->default('')->comment('短信发送配置');
            $table->string('sms_template')->nullable()->default('')->comment('短信发送配置');

            $table->timestamps();
            $table->softDeletes();

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sys_settings');
    }
}
