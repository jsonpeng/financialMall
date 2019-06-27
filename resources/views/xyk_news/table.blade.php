<table class="table table-responsive" id="xykNews-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图片</th>
            <th>申请数</th>
            <th>热门</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($xykNews as $xykNew)
        <tr>
            <td>{!! $xykNew->name !!}</td>
            <td><img src="{!! $xykNew->image !!}" style="height: 25px; width: auto;"></td>
            <td>{!! $xykNew->applier !!}</td>
            <td>{!! $xykNew->hot !!}</td>
            <td>
                {!! Form::open(['route' => ['xykNews.destroy', $xykNew->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('xykNews.show', [$xykNew->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('xykNews.edit', [$xykNew->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>