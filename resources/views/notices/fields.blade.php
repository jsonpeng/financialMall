<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '标题:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- View Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('view', '浏览量:') !!}
    {!! Form::text('view', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-12">
    <label class="fb">{!! Form::checkbox('popup', 1, null, ['class' => 'field minimal']) !!}自动弹窗显示</label>
</div>

<!-- Intro Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '正文:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Image Field 
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    {!! Form::text('image', null, ['class' => 'form-control']) !!}
</div>-->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('notices.index') !!}" class="btn btn-default">取消</a>
</div>
