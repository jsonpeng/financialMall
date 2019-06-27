<table class="table table-responsive" id="complaintLogs-table">
    <thead>
        <tr>
        <th>反馈类型</th>
        <th>反馈内容</th>
        <th>反馈人</th>
        <th>反馈人联系方式</th>
        <th>反馈图1</th>
        <th>反馈图2</th>
        <th>反馈图3</th>
        <th>反馈时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($complaintLogs as $complaintLog)
        <tr>
            <td>{!! $complaintLog->type !!}</td>
            <td>{!! $complaintLog->content !!}</td>
            <td>{!! optional($complaintLog->user)->name !!}</td>
            <td>{!! $complaintLog->commit !!}</td>
            <td><img src="{!! $complaintLog->image1 !!}" style="max-width: 80px;height: auto;" /></td>
            <td><img src="{!! $complaintLog->image2 !!}" style="max-width: 80px;height: auto;" /></td>
            <td><img src="{!! $complaintLog->image3 !!}" style="max-width: 80px;height: auto;" /></td>
            <td>{!! $complaintLog->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['complaintLogs.destroy', $complaintLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
            {{--         <a href="{!! route('complaintLogs.show', [$complaintLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('complaintLogs.edit', [$complaintLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>