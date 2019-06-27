<table class="table table-responsive" id="notices-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>浏览量</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($notices as $notice)
        <tr>
            <td>{!! $notice->name !!}</td>
            <td>{!! $notice->view !!}</td>
            <td>
                {!! Form::open(['route' => ['notices.destroy', $notice->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('notices.edit', [$notice->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>