<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Des Field -->
<div class="form-group col-sm-12">
    {!! Form::label('des', '描述(将会显示在名称后面，字数控制在10字以内，也可不填):') !!}
    {!! Form::text('des', null, ['class' => 'form-control']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-12">
    {!! Form::label('money', '售价:') !!}
    {!! Form::text('money', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('days', '会员时长(天):') !!}
    {!! Form::number('days', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('attach_words', '会员权益(多个用空格分隔开):') !!}
    {!! Form::textarea('attach_words', null, ['class' => 'form-control','rows' => '6']) !!}
</div>

<div class="form-group col-sm-12">
{!! Form::label('level', '会员等级(请根据价格调整,越高会员权限越高):') !!}
    @if(isset($userLevel))
        {!! Form::number('level', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
    @else
        {!! Form::number('level', null, ['class' => 'form-control']) !!}
    @endif
</div>


@if (Config::get('zcjy.OPEN_SHARE'))
<!-- <div class="form-group col-sm-12">
    {!! Form::label('level_money_11', '一级提成:') !!}
    {!! Form::number('level_money_11', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('level_money_12', '二级提成:') !!}
    {!! Form::number('level_money_12', null, ['class' => 'form-control']) !!}
</div> -->
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userLevels.index') !!}" class="btn btn-default">取消</a>
</div>
