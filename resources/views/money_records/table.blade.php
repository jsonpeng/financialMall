<table class="table table-responsive" id="moneyRecords-table">
    <thead>
        <tr>
            <th>用户Id</th>
            <th>用户昵称</th>
            <th>金额</th>
            <th>状态</th>
            <th>类型</th>
            <th>信息</th>
            <th>申请时间</th>
            <th>更新时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($moneyRecords as $moneyRecord)
        <tr>
            <td>{!! $moneyRecord->user_id !!}</td>
            <td>{!! $moneyRecord->user->nickname !!}</td>
            <td>{!! $moneyRecord->money !!}</td>
            <td>{!! $moneyRecord->status !!}</td>
            <td>{!! $moneyRecord->type !!}</td>
            <td>{!! $moneyRecord->info !!}</td>
            <td>{!! $moneyRecord->created_at !!}</td>
            <td>{!! $moneyRecord->updated_at !!}</td>
            <td>
                {!! Form::open(['route' => ['moneyRecords.destroy', $moneyRecord->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!--a href="{!! route('moneyRecords.show', [$moneyRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a-->
                    <a href="{!! route('moneyRecords.edit', [$moneyRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>