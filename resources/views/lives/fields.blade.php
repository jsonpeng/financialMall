<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '标题:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($highLevelInfo)) {{$highLevelInfo->image}}  @endif" style="max-width: 100%; width: auto; max-height: 120px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">上传</a>
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('member', '浏览权限:') !!}
    <select name="member" class="form-control">
            <option value="0" @if(!isset($live) || isset($live) && !$live->member) selected="selected" @endif>免费</option>
            <option value="1" @if(isset($live) && $live->member) selected="selected" @endif>需要会员</option>
    </select>
</div>

<!-- Content Field -->
<div class="form-group col-sm-12">
    {!! Form::label('content', '内容(直播链接):') !!}
    {!! Form::text('content', null, ['class' => 'form-control']) !!}
</div>

<!-- Time Field -->
<div class="form-group col-sm-12">
    {!! Form::label('time', '开播时间:') !!}
    {!! Form::text('time', null, ['class' => 'form-control', 'id' => 'time_start']) !!}
</div>

<!-- End Time Field -->
<div class="form-group col-sm-12">
    {!! Form::label('end_time', '结束时间:') !!}
    {!! Form::text('end_time', null, ['class' => 'form-control', 'id' => 'time_end']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('lives.index') !!}" class="btn btn-default">取消</a>
</div>
