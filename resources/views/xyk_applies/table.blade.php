<table class="table table-responsive" id="xykApplies-table">
    <thead>
        <tr>
            <th>姓名</th>
            <th>电话</th>
            <th>信息</th>
            <th>提交时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($xykApplies as $xykApply)
        <tr>
            <td>{!! $xykApply->name !!}</td>
            <td>{!! $xykApply->mobile !!}</td>
            <td>{!! $xykApply->info !!}</td>
            <td>{!! $xykApply->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['xykApplies.destroy', $xykApply->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('xykApplies.show', [$xykApply->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('xykApplies.edit', [$xykApply->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $xykApplies->render() !!}