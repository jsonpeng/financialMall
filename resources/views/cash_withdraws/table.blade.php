<table class="table table-responsive" id="cashWithdraws-table">
    <thead>
        <tr>
            <th>申请用户</th>
            <th>提取金额</th>
            <th>用户姓名</th>
            <th>支付宝账号</th>
            <th>状态</th>
            <th>交易号</th>
            <th>商户号</th>
            <th>审批时间</th>
            <th>申请时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cashWithdraws as $cashWithdraw)
        <tr>
            <td>{!! $cashWithdraw->user_id !!}</td>
            <td>{!! $cashWithdraw->count !!}</td>
            <td>{!! $cashWithdraw->name !!}</td>
            <td>{!! $cashWithdraw->zhifubao !!}</td>
            <td>{!! $cashWithdraw->status !!}</td>
            <td>{!! $cashWithdraw->trade_no !!}</td>
            <td>{!! $cashWithdraw->out_trade_no !!}</td>
            <td>{!! $cashWithdraw->operate_time !!}</td>
            <td>{!! $cashWithdraw->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['cashWithdraws.destroy', $cashWithdraw->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('cashWithdraws.edit', [$cashWithdraw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>