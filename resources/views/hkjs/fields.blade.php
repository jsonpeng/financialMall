<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', '分类:') !!}
    <div style="overflow: hidden;">
        <select name="hkj_cat_id" class="form-control">
        @foreach ($categories as $tmp)
            <option value="{{$tmp->id}}" @if(!empty($hkj) && $hkj->hkj_cat_id == $tmp->id) selected="selected" @endif>{!! $tmp->name !!}</option>
        @endforeach
        </select>
    </div>
</div>

<div class="form-group col-sm-12">
    <label class="fb">{!! Form::checkbox('hot', 1, null, ['class' => 'field minimal']) !!}热门</label>
</div>

{{-- <div class="form-group col-sm-12">
    {!! Form::label('free', '免费浏览:') !!}
    {!! Form::select('free', ['否'=>'否', '是'=>'是'], null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-12">
    {!! Form::label('level', '浏览权限:') !!}
    {!! Form::select('level', $levels, null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($hkj)) {{$hkj->image}} @else http://temp.im/180x120/333/EEE @endif" style="max-width: 100%; width: 180px; height: 120px; display: block; ">
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
    <a href="{!! route('hkjs.index') !!}" class="btn btn-default">取消</a>
</div>
