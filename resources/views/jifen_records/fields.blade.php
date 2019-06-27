<!-- Oemchannelid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('oemChannelId', 'Oemchannelid:') !!}
    {!! Form::text('oemChannelId', null, ['class' => 'form-control']) !!}
</div>

<!-- Clientno Field -->
<div class="form-group col-sm-6">
    {!! Form::label('clientNo', 'Clientno:') !!}
    {!! Form::text('clientNo', null, ['class' => 'form-control']) !!}
</div>

<!-- Channeltagid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('channelTagId', 'Channeltagid:') !!}
    {!! Form::text('channelTagId', null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-6">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::text('content', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- Money All Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money_all', 'Money All:') !!}
    {!! Form::text('money_all', null, ['class' => 'form-control']) !!}
</div>

<!-- Money User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money_user', 'Money User:') !!}
    {!! Form::text('money_user', null, ['class' => 'form-control']) !!}
</div>

<!-- Money Level1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money_level1', 'Money Level1:') !!}
    {!! Form::text('money_level1', null, ['class' => 'form-control']) !!}
</div>

<!-- Money Level2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money_level2', 'Money Level2:') !!}
    {!! Form::text('money_level2', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jifenRecords.index') !!}" class="btn btn-default">Cancel</a>
</div>
