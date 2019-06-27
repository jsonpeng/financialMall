<!-- User Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('user_id', '用户ID:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('money', '金额:') !!}
    {!! Form::text('money', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '银行名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('bank_name', '支行名称:') !!}
    {!! Form::text('bank_name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('user_name', '姓名:') !!}
    {!! Form::text('user_name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('count', '账号:') !!}
    {!! Form::text('count', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('mobile', '手机号:') !!}
    {!! Form::text('mobile', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['已完成' => '已完成', '处理中' => '处理中', '拒绝' => '拒绝'] , null, ['class' => 'form-control']) !!} 
</div>


<!-- Info Field -->
<div class="form-group col-sm-12">
    {!! Form::label('info', 'Info:') !!}
    {!! Form::text('info', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('确认', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('moneyRecords.index') !!}" class="btn btn-default">取消</a>
</div>
