<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('cat_id', '工具分类:') !!}
    <div style="overflow: hidden;">
        <select name="cat_id" class="form-control">
        @foreach ($toolCats as $tmp)
            <option value="{{$tmp->id}}" @if(!empty($tool) && $tool->cat_id == $tmp->id) selected="selected" @endif>{!! $tmp->name !!}</option>
        @endforeach
        </select>
    </div>
</div>


<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        <img src="@if(!empty($tool)) {{$tool->image}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', '链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
    <p>如果是跳转网页请填写链接，如果是拨打电话此项留空</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('mobile', '联系电话:') !!}
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
    <p>如果是拨打电话则填写联系电话，如果是跳转网页此项留空</p>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tools.index') !!}" class="btn btn-default">取消</a>
</div>
