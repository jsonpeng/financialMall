<table class="table table-responsive" id="selectionsTopics-table">
    <thead>
        <tr>
        <th>选项</th>
        <th>选项内容</th>
        <th>是否是答案</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($selectionsTopics as $selectionsTopic)
        <tr>
            <td>{!! $selectionsTopic->type !!}</td>
            <td>{!! $selectionsTopic->content !!}</td>
            <td>{!! empty($selectionsTopic->is_result) ? '否' : '是' !!}</td>
            <td>
                {!! Form::open(['route' => ['selectionsTopics.destroy',$topic->id,$selectionsTopic->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
           {{--          <a href="{!! route('selectionsTopics.show', [$selectionsTopic->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('selectionsTopics.edit', [$topic->id,$selectionsTopic->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>