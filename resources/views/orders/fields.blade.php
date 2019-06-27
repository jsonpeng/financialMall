<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money', 'Money:') !!}
    {!! Form::text('money', null, ['class' => 'form-control']) !!}
</div>

<!-- Pay No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pay_no', 'Pay No:') !!}
    {!! Form::text('pay_no', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('orders.index') !!}" class="btn btn-default">Cancel</a>
</div>
