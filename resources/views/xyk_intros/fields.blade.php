<!-- Intro Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '业务介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('xykIntros.index') !!}" class="btn btn-default">取消</a>
</div>
