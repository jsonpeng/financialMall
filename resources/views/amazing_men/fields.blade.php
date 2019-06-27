<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '达人名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-12">
    {!! Form::label('email', '邮箱:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-12">
    {!! Form::label('password', '密码:') !!}

    @if(isset($amazingMan))
       {!! Form::text('password','', ['class' => 'form-control']) !!}
    @else
       {!! Form::text('password', null, ['class' => 'form-control']) !!}
    @endif

</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <img src="@if(!empty($amazingMan)) {{$amazingMan->image}} @else http://temp.im/180x120/333/EEE @endif" style="max-width: 100%; width: 180px; height: 120px; display: block; ">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片(180x120)</a>
    </div>
</div>

<!-- Job Field -->
<div class="form-group col-sm-12">
    {!! Form::label('job', '职称:') !!}
    {!! Form::text('job', null, ['class' => 'form-control']) !!}
</div>

<!-- Des Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('des', '描述介绍:') !!}
    {!! Form::textarea('des', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Fans Field -->
<div class="form-group col-sm-12">
    {!! Form::label('fans', '粉丝数量:') !!}
    {!! Form::number('fans', null, ['class' => 'form-control']) !!}
</div>

<!-- Contact Field -->
<div class="form-group col-sm-12">
    {!! Form::label('contact', '联系方式:') !!}
    {!! Form::text('contact', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('weixin', '微信:') !!}
    {!! Form::text('weixin', null, ['class' => 'form-control']) !!}
</div>

{!! Form::hidden('type', '达人', ['class' => 'form-control']) !!}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('amazingMen.index') !!}" class="btn btn-default">返回</a>
</div>
