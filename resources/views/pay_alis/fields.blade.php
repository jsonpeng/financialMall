<!-- App Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('app_id', '应用APP ID:') !!}
    {!! Form::text('app_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('payAlis.index') !!}" class="btn btn-default">取消</a>
</div>
