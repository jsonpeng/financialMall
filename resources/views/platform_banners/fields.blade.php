<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($platformBanner)) {{$platformBanner->image}} @else http://temp.im/640x270/333/EEE @endif" style="max-width: 100%; max-height: 150px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片(640x270)</a>
    </div>
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', '链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序:') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('platformBanners.index') !!}" class="btn btn-default">取消</a>
</div>
