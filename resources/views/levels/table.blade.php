<table class="table table-responsive" id="levels-table">
    <thead>
        <tr>
            <th>合伙人星级名称</th>
            <th>排序</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($levels as $level)
        <tr>
            <td>{!! $level->name !!}</td>
            <td>{!! $level->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['levels.destroy', $level->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{!! route('levels.show', [$level->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                     <a href="{!! route('levels.edit', [$level->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>