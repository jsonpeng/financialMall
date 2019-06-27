<table class="table table-responsive" id="lives-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图片</th>
            <th>浏览权限</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lives as $live)
        <tr>
            <td>{!! $live->name !!}</td>
            <td>{!! $live->image !!}</td>
            <td>{!! $live->member ? '需要会员' : '免费'!!}</td>
            <td>{!! $live->time !!}</td>
            <td>{!! $live->end_time !!}</td>
            <td>
                {!! Form::open(['route' => ['lives.destroy', $live->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{!! route('lives.show', [$live->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('lives.edit', [$live->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>