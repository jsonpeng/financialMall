<table class="table table-responsive" id="payAlis-table">
    <thead>
        <tr>
            <th>应用ID</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payAlis as $payAli)
        <tr>
            <td>{!! $payAli->app_id !!}</td>
            <td>
                {!! Form::open(['route' => ['payAlis.destroy', $payAli->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('payAlis.edit', [$payAli->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>