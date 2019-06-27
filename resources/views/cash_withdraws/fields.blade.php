<!-- User Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Count Field -->
<div class="form-group col-sm-12">
    {!! Form::label('count', '提取金额:') !!}
    {!! Form::number('count', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '姓名:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Zhifubao Field -->
<div class="form-group col-sm-12">
    {!! Form::label('zhifubao', '支付宝账号:') !!}
    {!! Form::text('zhifubao', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

@if ($cashWithdraw->status == '待审核')
    <div class="form-group col-sm-12">
        {!! Form::label('reason', '备注:') !!}
        {!! Form::text('reason', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        <div class="btn btn-success" onclick="confirm()">同意</div>
        <div class="btn btn-warning" onclick="reject()">拒绝</div>
    </div>

@endif

@if ($cashWithdraw->status == '审核通过')
    <!-- Trade No Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('trade_no', '交易号:') !!}
        <div class="form-control"> {!! $cashWithdraw->trade_no !!} </div>
    </div>

    <!-- Out Trade No Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('out_trade_no', '商户号:') !!}
        <div class="form-control"> {!! $cashWithdraw->out_trade_no !!} </div>
    </div>
@endif

@if ($cashWithdraw->status == '审核不通过')
    <div class="form-group col-sm-12">
        {!! Form::label('reason', '备注:') !!}
        {!! Form::text('reason', null, ['class' => 'form-control']) !!}
    </div>
@endif

@if ($cashWithdraw->status == '失败')
    <!-- Reason Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('reason', '备注:') !!}
        {!! Form::text('reason', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <a href="{!! route('cashWithdraws.index') !!}" class="btn btn-default">返回</a>
</div>


