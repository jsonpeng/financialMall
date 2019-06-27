<!-- Level Info Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level_info_id', 'Level Info Id:') !!}
    {!! Form::text('level_info_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Sound Post Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sound_post_id', 'Sound Post Id:') !!}
    {!! Form::text('sound_post_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('levelSounds.index') !!}" class="btn btn-default">Cancel</a>
</div>
