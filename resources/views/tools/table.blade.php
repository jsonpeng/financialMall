<table class="table table-responsive" id="tools-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>分类</th>
            <th>图片</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tools as $tool)
        <tr>
            <td>{!! $tool->name !!}</td>
            <td>{!! optional($tool->cat)->name !!}</td>
            <td><img src="{!! $tool->image !!}" alt="" style="height: 25px; width: auto;"></td>
            <td>
                {!! Form::open(['route' => ['tools.destroy', $tool->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{!! route('tools.show', [$tool->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('tools.edit', [$tool->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>