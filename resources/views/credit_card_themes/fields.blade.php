<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '主题:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图标:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($creditCardTheme)) {{$creditCardTheme->image}} @else http://temp.im/50x50/333/EEE @endif" style="max-width: 100%; max-height: 150px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片</a>
    </div>
</div>

<!-- Brief Field -->
<div class="form-group col-sm-12">
    {!! Form::label('brief', '简介:') !!}
    {!! Form::text('brief', null, ['class' => 'form-control']) !!}
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序:') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('creditCardThemes.index') !!}" class="btn btn-default">取消</a>
</div>
