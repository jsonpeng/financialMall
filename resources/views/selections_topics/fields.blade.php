<!-- Type Field -->
<div class="form-group col-sm-8">
    {!! Form::label('type', '选项:') !!}
    <select name="type" class="form-control">
    	@foreach ($selects as $item)
    		<option value="{{ $item }}" @if(!empty($selectionsTopic) && $selectionsTopic->type == $item) selected="selected" @endif>{{ $item }}</option>
    	@endforeach
    </select>
</div>

<!-- Content Field -->
<div class="form-group col-sm-8 ">
    {!! Form::label('content', '选项内容:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
</div>

<!-- Topic Id Field -->

{!! Form::hidden('topic_id', $topic->id, ['class' => 'form-control']) !!}

<div class="form-group col-sm-8">
    {!! Form::label('type', '是否是答案:') !!}
    <select name="is_result" class="form-control">
    
    		<option value="0" @if(!empty($selectionsTopic) && $selectionsTopic->is_result == 0) selected="selected" @endif>否</option>
			<option value="1" @if(!empty($selectionsTopic) && $selectionsTopic->is_result == 1) selected="selected" @endif>是</option>
	</select>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('selectionsTopics.index',$topic->id) !!}" class="btn btn-default">返回</a>
</div>
