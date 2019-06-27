<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($product)) {{$product->image}} @else http://temp.im/50x50/333/EEE @endif" style="max-width: 100%; max-height: 150px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片</a>
    </div>
</div>

<!-- Price Field
<div class="form-group col-sm-12">
    {!! Form::label('price', '售价:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Des Field -->
<div class="form-group col-sm-12">
    {!! Form::label('des', '描述:') !!}
    {!! Form::text('des', null, ['class' => 'form-control']) !!}
</div>

<!-- Sales Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sales', '已售数量:') !!}
    {!! Form::number('sales', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Field -->
{{-- <div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div>
 --}}
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('products.index') !!}" class="btn btn-default">取消</a>
</div>
