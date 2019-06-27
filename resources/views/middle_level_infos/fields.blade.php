<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', '标题:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Des Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('des', '描述:') !!} --}}
    {!! Form::hidden('des', 1, ['class' => 'form-control']) !!}



<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($highLevelInfo)) {{$highLevelInfo->image}}  @endif" style="max-width: 100%; width: auto; max-height: 120px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">上传</a>
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('cat_id', '课程分类:') !!}
    <select name="cat_id" class="form-control">
        <option value="0" @if(!isset($middleLevelInfo)) selected="selected" @endif>无</option>
        @foreach($cats as $cat)
            <option value="{!! $cat->id !!}" @if(isset($middleLevelInfo) && $middleLevelInfo->cat_id == $cat->id) selected="selected" @endif>{!! $cat->name !!}</option>
        @endforeach
    </select>
</div>

<?php $sound_posts = app('commonRepo')->SoundPostRepo()->all(); ?>
@if(count($sound_posts))
<!--       <div class="form-group col-sm-12" style="overflow: hidden;">
           {!! Form::label('sound_posts', '音频课程系列:') !!}
      </div>
    <div class="form-group col-sm-12" style="overflow: hidden;">
                @foreach ($sound_posts as $category)
                    <div style="float: left; margin-right: 20px; ">
                        <label>
                     {!! Form::checkbox('sound_posts[]', $category->id, in_array($category->id, $selectedCategories), ['class' => 'select_xilie']) !!}
                            {!! $category->name !!}
                        </label></br>
                    </div>
                @endforeach
    </div> -->
@endif

<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', '类型:') !!}
    {!! Form::select('type', ['语音' => '语音', '视频' => '视频'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('level', '浏览权限:') !!}
    {!! Form::select('level', $levels, null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', '链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
    <!-- <div id="fileUploader">上传文件</div> -->

    {{-- <input name="file" type="file" id="fileUploader" /> --}}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('all_count_time', '观看时长:(参考60:00=>60分钟这种格式)') !!}
    {!! Form::text('all_count_time', null, ['class' => 'form-control','placeholder'=>'00:00']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('jifen', '赠送积分:') !!}
    {!! Form::number('jifen', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('view', '浏览量:') !!}
    {!! Form::number('view', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '简介:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('middleLevelInfos.index') !!}" class="btn btn-default">取消</a>
</div>
