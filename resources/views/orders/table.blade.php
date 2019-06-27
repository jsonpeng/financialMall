<table class="table table-responsive" id="orders-table">
    <thead>
        <tr>
            <th>购买人姓名</th>
            <th>姓名</th>
            <th>电话</th>
            <th>金额</th>
            <th>商户号</th>
            <th>交易号</th>
            <th>时间</th>
            <th>支付状态</th>
            {{-- <th colspan="3">操作</th> --}}
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{!! optional($order->user)->name  !!}</td>
            <td>{!! $order->user->name !!}</td>
            <td>{!! $order->user->mobile !!}</td>
            <td>{!! $order->money !!}</td>
            <td>{!! $order->pay_no !!}</td>
            <td>{!! $order->trade_no !!}</td>
            <td>{!! $order->created_at !!}</td>
            <td>{!! $order->pay_status !!}</td>
     {{--        <td>
                {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {!! Form::button('<span>删除</span>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?删除后所有关联订单信息会销毁且删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td> --}}
        </tr>
    @endforeach
    </tbody>
</table>