<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('cat_id', '系列分类:') !!}
    {!! Form::select('cat_id', $cats, null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(isset($soundPost)) {{$soundPost->image}} @else http://temp.im/180x120/333/EEE @endif" style="max-width: 100%; width: 180px; height: 120px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片(180x120)</a>
    </div>
</div>

<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('view', '浏览量:') !!}
    {!! Form::number('view', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('free_info', '免费内容:') !!}
    {!! Form::textarea('free_info', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Intro Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '收费内容:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('soundPosts.index') !!}" class="btn btn-default">取消</a>
</div>

