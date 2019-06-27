<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySubmitForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('submit_forms', 'xueli')) {
            Schema::table('submit_forms', function (Blueprint $table) {
                $table->text('xueli')->nullable()->comment('学历');
                $table->text('zhimafen')->nullable()->comment('芝麻分');
                $table->text('email')->nullable()->comment('邮箱');
                $table->text('email_pass')->nullable()->comment('邮箱密码');
                $table->text('qq')->nullable()->comment('qq');
                $table->text('idcard')->nullable()->comment('身份证');
                $table->text('marrage')->nullable()->comment('婚姻状况');
                $table->text('bank_count')->nullable()->comment('储蓄卡账号');
                $table->text('bank_name')->nullable()->comment('银行名称');
                $table->text('money_flow')->nullable()->comment('有无流水');
                $table->text('credit_card')->nullable()->comment('信用卡号');
                $table->text('edu_used')->nullable()->comment('已用额度');
                $table->text('edu_all')->nullable()->comment('总额度');
                $table->text('credit_card_extra')->nullable()->comment('信用卡额外信息');

                $table->integer('house_money')->nullable()->comment('房贷金额');
                $table->integer('house_time')->nullable()->comment('房贷时长');
                $table->text('house_bank')->nullable()->comment('房贷银行');

                $table->integer('car_money')->nullable()->comment('车贷金额');
                $table->integer('car_time')->nullable()->comment('车贷时长');
                $table->integer('car_bank')->nullable()->comment('车贷银行');

                $table->text('address')->nullable()->comment('现居住地址');
                $table->text('houce_owner')->nullable()->comment('房子属于');

                $table->text('company')->nullable()->comment('工作单位');
                $table->text('company_tel')->nullable()->comment('工作单位座机');
                $table->text('company_address')->nullable()->comment('工作单位地址');
                $table->text('zhiwei')->nullable()->comment('职位');
                $table->text('bumen')->nullable()->comment('部门');
                $table->integer('gongling')->nullable()->comment('工龄');
                $table->float('salary')->nullable()->comment('工资');
                $table->text('salary_way')->nullable()->comment('结算方式');

                $table->text('loan1_name')->nullable()->comment('贷款名称');
                $table->text('loan1_money')->nullable()->comment('贷款金额');
                $table->text('loan1_compay')->nullable()->comment('贷款单位');

                $table->text('loan2_name')->nullable()->comment('贷款名称');
                $table->text('loan2_money')->nullable()->comment('贷款金额');
                $table->text('loan2_compay')->nullable()->comment('贷款单位');

                $table->text('loan3_name')->nullable()->comment('贷款名称');
                $table->text('loan3_money')->nullable()->comment('贷款金额');
                $table->text('loan3_compay')->nullable()->comment('贷款单位');
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
        //
    }
}
