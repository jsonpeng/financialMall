<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '分类名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

{{-- <div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($hkjCat)) {{$hkjCat->image}} @else http://temp.im/75x75/333/EEE @endif" style="max-width: 100%; height: 75px; width: 75px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片(75x75)</a>
    </div>
</div> --}}

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序(数值越大越靠前):') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>

<!-- Shoufei Field 
<div class="form-group col-sm-12">
    {!! Form::label('shoufei', 'Shoufei:') !!}
    {!! Form::number('shoufei', null, ['class' => 'form-control']) !!}
</div>
-->
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('hkjCats.index') !!}" class="btn btn-default">取消</a>
</div>
