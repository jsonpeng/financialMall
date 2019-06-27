<table class="table table-responsive" id="creditCardBanks-table">
    <thead>
        <tr>
            <th>银行名称</th>
            <th>LOGO</th>
            <th>排序</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($creditCardBanks as $creditCardBank)
        <tr>
            <td>{!! $creditCardBank->name !!}</td>
            <td><img src="{!! $creditCardBank->image !!}" style="height: 25px;"></td>
            <td>{!! $creditCardBank->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['creditCardBanks.destroy', $creditCardBank->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('creditCardBanks.show', [$creditCardBank->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('creditCardBanks.edit', [$creditCardBank->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>