<!-- Channel Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('channel_name', '平台名称:') !!}
    {!! Form::select('channel_name', ['微洽通' => '微洽通'], null, ['class' => 'form-control']) !!}
</div>

<!-- Shelf Field -->
<div class="form-group col-sm-12">
    <label class="fb">{!! Form::checkbox('shelf', 1, null, ['class' => 'field minimal']) !!}上架</label>
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '产品名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Channel Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('channel_id', '通道号:') !!}
    {!! Form::text('channel_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('type', '产品类型:') !!}
    {!! Form::select('type', ['贷款' => '贷款', '信用卡' => '信用卡', '彩票' => '彩票'], null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图标:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($shareDk)) {{$shareDk->image}} @else http://temp.im/60x60/333/EEE @endif" style="max-width: 100%; width: 60px; height: 60px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置</a>
    </div>
</div>

<!-- Des Field -->
<div class="form-group col-sm-12">
    {!! Form::label('des', '描述:') !!}
    {!! Form::text('des', null, ['class' => 'form-control']) !!}
</div>

<!-- Return Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('return_type', '返佣类型:') !!}
    {!! Form::select('return_type', ['固定金额' => '固定金额', '百分比' => '百分比'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('period', '结算周期:') !!}
    {!! Form::select('period', ['日结' => '日结','周结' => '周结','月结' => '月结'], null, ['class' => 'form-control']) !!}
</div>

<!-- Money Level1 Field -->
<div class="form-group col-sm-12">
    {!! Form::label('money_level1', '一级会员返佣:') !!}
    {!! Form::text('money_level1', null, ['class' => 'form-control']) !!}
</div>

<!-- Money Level2 Field -->
<div class="form-group col-sm-12">
    {!! Form::label('money_level2', '二级会员返佣:') !!}
    {!! Form::text('money_level2', null, ['class' => 'form-control']) !!}
</div>

<!-- Money Level3 Field -->
<div class="form-group col-sm-12">
    {!! Form::label('money_level3', '三级会员返佣:') !!}
    {!! Form::text('money_level3', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('intro', '介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div> --}}

<!-- Applied Field -->
<div class="form-group col-sm-12">
    {!! Form::label('applied', '申请人数:') !!}
    {!! Form::number('applied', null, ['class' => 'form-control']) !!}
</div>

<!-- Share Base Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('share_base', '分销二维码底图:') !!}
    {!! Form::text('share_base', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-12">
    {!! Form::label('share_base', '推广二维码底图:') !!}
    <div class="input-append">
        {!! Form::text('share_base', null, ['class' => 'form-control', 'id' => 'share_base']) !!}
        <img src="@if(!empty($shareDk)) {{$shareDk->share_base}} @else http://temp.im/60x60/333/EEE @endif" style="max-width: 100%; width: 200px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('share_base')" style="padding: 0;">设置</a>
    </div>
</div>

<!-- Period Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('period', 'Period:') !!}
    {!! Form::text('period', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('shareDks.index') !!}" class="btn btn-default">取消</a>
</div>
