<table class="table table-responsive" id="gaobaos-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图片</th>
            <th>链接</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($gaobaos as $gaobao)
        <tr>
            <td>{!! $gaobao->name !!}</td>
            <td><img src="{!! $gaobao->image !!}" style="height: 25px; width: auto;"></td>
            <td>{!! $gaobao->link !!}</td>
            <td>
                {!! Form::open(['route' => ['gaobaos.destroy', $gaobao->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{!! route('gaobaos.show', [$gaobao->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('gaobaos.edit', [$gaobao->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>