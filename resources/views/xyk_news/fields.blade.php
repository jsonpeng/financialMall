<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '行用卡名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($xykNew)) {{$xykNew->image}} @endif" style="max-width: 100%; width: auto; height: 120px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片</a>
    </div>
</div>

<!-- Applier Field -->
<div class="form-group col-sm-12">
    {!! Form::label('applier', '申请人数:') !!}
    {!! Form::number('applier', null, ['class' => 'form-control']) !!}
</div>

<!-- Hot Field -->
<div class="form-group col-sm-12">
    <label class="fb">{!! Form::checkbox('hot', 1, null, ['class' => 'field minimal']) !!}热门</label>
</div>

<!-- Intro Field -->
<div class="form-group col-sm-12">
    {!! Form::label('intro', '简介:') !!}
    {!! Form::text('intro', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', '申请链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('xykNews.index') !!}" class="btn btn-default">取消</a>
</div>
