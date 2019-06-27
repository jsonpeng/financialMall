<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', '分类名称') !!}<span class="required">(必填):</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12">
    {!! Form::label('image', '图像:') !!}

    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        <img src="@isset($paperType) {{$paperType->image}} @endisset" style="max-width: 100%; max-height: 150px; display: block;">
    </div>

</div>

<div class="form-group col-sm-8">
    {!! Form::label('level', '会员等级:') !!}
    {!! Form::select('level', ['初级会员' => '初级会员','中级会员' => '中级会员', '高级会员' => '高级会员'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('paperTypes.index') !!}" class="btn btn-default">返回</a>
</div>
