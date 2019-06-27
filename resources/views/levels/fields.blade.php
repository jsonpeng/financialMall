<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '合伙人星级名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序权重(越大排名越靠前):') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>

<!--       'level1_1',
        'level1_2',
        'level2_1',
        'level2_2' -->

<div class="form-group col-sm-12">
    {!! Form::label('level1_1', '黑金会员卡一级提成:') !!}
    {!! Form::number('level1_1', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('level1_2', '黑金会员卡二级提成:') !!}
    {!! Form::number('level1_2', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('level2_1', '白金会员卡一级提成:') !!}
    {!! Form::number('level2_1', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('level2_2', '白金会员卡二级提成:') !!}
    {!! Form::number('level2_2', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('levels.index') !!}" class="btn btn-default">返回</a>
</div>
