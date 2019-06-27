<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '网站名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('image', 'APP LOGO:') !!}
    <div class="input-append">
        {!! Form::text('logo', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        <img src="@if(isset($setting)) {{$setting->logo}} @endif" style="max-width: 100%; max-height: 50px; display: block;">
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('image', '分享二维码底图:') !!}
    <div class="input-append">
        {!! Form::text('base_share_img', null, ['class' => 'form-control', 'id' => 'base_share_img']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('base_share_img')">选择图片</a>
        <img src="@if(isset($setting)) {{$setting->base_share_img}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

{{-- <div class="form-group col-sm-12">
    {!! Form::label('scale', '一级提成比例0-70(%):') !!}
    {!! Form::number('scale', null, ['class' => 'form-control', 'min' => 0, 'max' => '70']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('scale_level2', '二级提成比例0-20(%):') !!}
    {!! Form::number('scale_level2', null, ['class' => 'form-control', 'min' => 0, 'max' => '20']) !!}
</div> --}}
@if (Config::get('zcjy.OPEN_SHARE'))
    <div class="form-group col-sm-6">
        {!! Form::label('min_cash', '最低提现金额') !!}
        {!! Form::number('min_cash', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('max_cash_withdraw', '每月最高提现次数') !!}
        {!! Form::number('max_cash_withdraw', null, ['class' => 'form-control']) !!}
    </div>

 {{--    <div class="form-group col-sm-12">
        {!! Form::label('chat_link', '在线客服') !!}
        {!! Form::text('chat_link', null, ['class' => 'form-control']) !!}
    </div>
 --}}
{{--     <div class="form-group col-sm-12">
        {!! Form::label('apk_link', '安卓下载地址') !!}
        {!! Form::text('apk_link', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-12">
        {!! Form::label('ios_link', '苹果下载地址') !!}
        {!! Form::text('ios_link', null, ['class' => 'form-control']) !!}
    </div> --}}
@else
{{--     <div class="form-group col-sm-12">
        {!! Form::label('apk_link', 'APP下载地址') !!}
        {!! Form::text('apk_link', null, ['class' => 'form-control']) !!}
    </div> --}}
@endif


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <!--a href="{!! route('settings.index') !!}" class="btn btn-default">取消</a-->
</div>
