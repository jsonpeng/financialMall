<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content', '推广软文资料:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('advertorials.index') !!}" class="btn btn-default">取消</a>
</div>
