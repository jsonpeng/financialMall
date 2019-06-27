<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '标题:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', '文章分类:') !!}
    <div style="overflow: hidden;">
        <select name="category_id" class="form-control">
        @foreach ($categories as $tmp)
            <option value="{{$tmp->id}}" @if(!empty($post) && $post->category_id == $tmp->id) selected="selected" @endif>{!! $tmp->name !!}</option>
        @endforeach
        </select>
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        <img src="@if(!empty($post)) {{$post->image}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Views Field -->
<div class="form-group col-sm-12">
    {!! Form::label('view', '浏览次数:') !!}
    {!! Form::number('view', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('posts.index') !!}" class="btn btn-default">取消</a>
</div>
