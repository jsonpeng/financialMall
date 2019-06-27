<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Last See Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_see_time', 'Last See Time:') !!}
    {!! Form::text('last_see_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Sound Post Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sound_post_id', 'Sound Post Id:') !!}
    {!! Form::text('sound_post_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_end', 'Whether End:') !!}
    {!! Form::text('whether_end', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('soundPostUserLogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
