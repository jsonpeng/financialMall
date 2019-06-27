<div class="form-group col-sm-8">
    {!! Form::label('sort', '试题序号:') !!}
    {!! Form::text('sort', $topic, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', '试题名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


{!! Form::hidden('paper_id', $paper->id, ['class' => 'form-control']) !!}


<!-- Sort Field -->


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('topics.index',$paper->id) !!}" class="btn btn-default">返回</a>
</div>
