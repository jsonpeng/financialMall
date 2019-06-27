<table class="table table-responsive" id="posApplies-table">
    <thead>
        <tr>
            <th>姓名</th>
            <th>电话</th>
            <th>信用卡张数</th>
            <th>邮寄地址</th>
            <th>申请时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posApplies as $posApply)
        <tr>
            <td>{!! $posApply->name !!}</td>
            <td>{!! $posApply->mobile !!}</td>
            <td>{!! $posApply->card_num !!}</td>
            <td>{!! $posApply->address !!}</td>
            <td>{!! $posApply->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['posApplies.destroy', $posApply->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('posApplies.show', [$posApply->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('posApplies.edit', [$posApply->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $posApplies->render() !!}