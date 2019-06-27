<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Paper Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paper_id', 'Paper Id:') !!}
    {!! Form::text('paper_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Paper Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paper_type_id', 'Paper Type Id:') !!}
    {!! Form::text('paper_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Topic Num Field -->
<div class="form-group col-sm-6">
    {!! Form::label('topic_num', 'Topic Num:') !!}
    {!! Form::text('topic_num', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Pass Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_pass', 'Is Pass:') !!}
    {!! Form::text('is_pass', null, ['class' => 'form-control']) !!}
</div>

<!-- Grade Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grade', 'Grade:') !!}
    {!! Form::text('grade', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('testRecords.index') !!}" class="btn btn-default">Cancel</a>
</div>
