<table class="table table-responsive" id="shareDkRecords-table">
    <thead>
        <tr>
            <th>终端号</th>
            <th>交易号</th>
            <th>推荐用户ID</th>
            <th>申请人姓名</th>
            <th>申请人手机</th>
            <th>类型</th>
            <th>产品ID</th>
            <th>状态</th>
            <th>审批金额</th>
            <th>申请时间</th>
            <th>更新时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($shareDkRecords as $shareDkRecord)
        <tr>
            <td>{!! $shareDkRecord->terminal_id !!}</td>
            <td>{!! $shareDkRecord->transNo !!}</td>
            <td>{!! $shareDkRecord->user_id !!}</td>
            <td>{!! $shareDkRecord->applier_name !!}</td>
            <td>{!! $shareDkRecord->applier_mobile !!}</td>
            <td>{!! $shareDkRecord->type !!}</td>
            <td>{!! $shareDkRecord->product_id !!}</td>
            <td>{!! $shareDkRecord->status !!}</td>
            <td>{!! $shareDkRecord->amount !!}</td>
            <td>{!! $shareDkRecord->created_at !!}</td>
            <td>{!! $shareDkRecord->updated_at !!}</td>
            <td>
                {{-- {!! Form::open(['route' => ['shareDkRecords.destroy', $shareDkRecord->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('shareDkRecords.show', [$shareDkRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('shareDkRecords.edit', [$shareDkRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!} --}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>