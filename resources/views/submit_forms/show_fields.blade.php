
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> {!! $submitForm->type !!}申请
            <small class="pull-right">申请日期: {!! $submitForm->created_at !!}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info" style="margin-bottom: 15px;">
        <div class="col-sm-4 invoice-col">
            <strong>{!! $submitForm->type !!}</strong><br>
            {!! $submitForm->user_name !!}<br>
            {!! $submitForm->mobile !!}<br>
            学历:  {!! $submitForm->xueli !!}<br>
            芝麻分:  {!! $submitForm->zhimafen !!}

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

            邮箱:  {!! $submitForm->email !!}<br>
            邮箱密码:  {!! $submitForm->email_pass !!}<br>
            qq:  {!! $submitForm->qq !!}<br>
            身份证:  {!! $submitForm->idcard !!}<br>
            婚姻状况:  {!! $submitForm->marrage !!}

        </div>
        <!-- /.col -->
        
    </div>
    <div class="row invoice-info" style="margin-bottom:   15px;">
        <div class="col-sm-4 invoice-col">
            储蓄卡账号:  {!! $submitForm->bank_count !!}<br>
            银行名称:  {!! $submitForm->bank_name !!}<br>
            有无流水:  {!! $submitForm->money_flow !!}<br>
        </div>

        <div class="col-sm-4 invoice-col">
            信用卡号:  {!! $submitForm->credit_card !!}<br>
            已用额度:  {!! $submitForm->edu_used !!}<br>
            总额度:  {!! $submitForm->edu_all !!}<br>
            信用卡额外信息:  {!! $submitForm->credit_card_extra !!}<br>
        </div>

        <div class="col-sm-4 invoice-col">
            房贷金额:  {!! $submitForm->house_money !!}<br>
            房贷时长:  {!! $submitForm->house_time !!}<br>
            房贷银行:  {!! $submitForm->house_bank !!}<br>
            车贷金额:  {!! $submitForm->car_money !!}<br>
            车贷时长:  {!! $submitForm->car_time !!}<br>
            车贷银行:  {!! $submitForm->car_bank !!}<br>
        </div>

        

        <!-- /.col -->
        </div>
      <!-- /.row -->
        <div class="row invoice-info" style="margin-bottom:   15px;">

            <div class="col-sm-4 invoice-col">
            现居住地址:  {!! $submitForm->address !!}<br>
            房子属于:  {!! $submitForm->houce_owner !!}<br>
            工作单位:  {!! $submitForm->company !!}<br>
            工作单位座机:  {!! $submitForm->company_tel !!}<br>
            工作单位地址:  {!! $submitForm->company_address !!}<br>
        </div>
        
            <div class="col-sm-4 invoice-col">
                职位:  {!! $submitForm->zhiwei !!}<br>
                部门:  {!! $submitForm->bumen !!}<br>
                工龄:  {!! $submitForm->gongling !!}<br>
                工资:  {!! $submitForm->salary !!}<br>
                结算方式:  {!! $submitForm->salary_way !!}<br>
            </div>
        </div>

      <!-- Table row -->
      <div class="row">
        <div>其他平台贷款信息</div>
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>贷款名称</th>
              <th>贷款金额</th>
              <th>贷款单位</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>{!! $submitForm->loan1_name !!}</td>
              <td>{!! $submitForm->loan1_money !!}</td>
              <td>{!! $submitForm->loan1_compay !!}</td>
            </tr>
            <tr>
              <td>{!! $submitForm->loan2_name !!}</td>
              <td>{!! $submitForm->loan2_money !!}</td>
              <td>{!! $submitForm->loan2_compay !!}</td>
            </tr>
            <tr>
              <td>{!! $submitForm->loan3_name !!}</td>
              <td>{!! $submitForm->loan3_money !!}</td>
              <td>{!! $submitForm->loan3_compay !!}</td>
            </tr>
            
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
