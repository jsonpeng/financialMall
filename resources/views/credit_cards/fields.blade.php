<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '信用卡名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Brief Field -->
<div class="form-group col-sm-12">
    {!! Form::label('brief', '简介:') !!}
    {!! Form::text('brief', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        @if(!empty($creditCard))<img src=" {{$creditCard->image}} " style="max-width: 100%; max-height: 150px; display: block;">@endif
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', '所属银行:') !!}
    <div style="overflow: hidden;">
        <select name="credit_card_bank_id" class="form-control">
        @foreach ($creditCardBanks as $tmp)
            <option value="{{$tmp->id}}" @if(!empty($creditCard) && $creditCard->credit_card_bank_id == $tmp->id) selected="selected" @endif>{!! $tmp->name !!}</option>
        @endforeach
        </select>
    </div>
</div>

{{-- <div class="form-group col-sm-12">
    {!! Form::label('name', '所属主题:') !!}
    <div style="overflow: hidden;">
        <select name="credit_card_theme_id" class="form-control">
        @foreach ($creditCardThemes as $tmp)
            <option value="{{$tmp->id}}" @if(!empty($creditCard) && $creditCard->credit_card_theme_id == $tmp->id) selected="selected" @endif>{!! $tmp->name !!}</option>
        @endforeach
        </select>
    </div>
</div> --}}

<!-- View Field -->
<div class="form-group col-sm-12">
    {!! Form::label('view', '申请人数:') !!}
    {!! Form::number('view', null, ['class' => 'form-control']) !!}
</div>

<!-- Remark Field -->
<div class="form-group col-sm-12">
    {!! Form::label('remark', '特色(多个特色英文逗号,分割):') !!}
    {!! Form::text('remark', null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', '办理链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    <label class="fb">{!! Form::checkbox('hot', 1, null, ['class' => 'field minimal']) !!}热门</label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('creditCards.index') !!}" class="btn btn-default">取消</a>
</div>
