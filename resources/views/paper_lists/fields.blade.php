<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', '试卷名称:') !!}<span class="required">(必填):</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

{{-- <div class="form-group col-sm-8">
    {!! Form::label('paper_type_id', '试卷分类:') !!}<span class="required">(必选):</span>
    @if(count($paper_types))
    <select name="paper_type_id" class="form-control">
    			<option value="">请选择试卷分类</option>
    	@foreach ($paper_types as $item)
    			<option value="{{ $item->id }}" @if(!empty($paperList) && $paperList->paper_type_id == $item->id) selected="selected" @endif>
    				{{ $item->name }}
    			</option>
    	@endforeach
    </select>
    @else
    <a href="{!! route('paperTypes.create') !!}">添加试卷分类</a>
    @endif
</div> --}}

<!-- Level Field -->
<div class="form-group col-sm-8">
    {!! Form::label('level', '难度等级:') !!}<span class="required">(必选):</span>
    <select name="level" class="form-control">
    			<option value="">请选择试卷难度等级</option>
    	@foreach ($levels as $item)
    			<option value="{{ $item }}" @if(!empty($paperList) && $paperList->level == $item) selected="selected" @endif>
    				{{ $item }}
    			</option>
    	@endforeach
    </select>
</div>

<!-- Pass Grade Field -->
<div class="form-group col-sm-8">
    {!! Form::label('pass_grade', '及格通过分数:') !!}<span class="required">(必填):</span>
    {!! Form::text('pass_grade', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('paperLists.index') !!}" class="btn btn-default">返回</a>
</div>
