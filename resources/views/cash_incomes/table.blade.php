<table class="table table-responsive" id="cashIncomes-table">
    <thead>
        <tr>
            <th>User Id</th>
        <th>Type</th>
        <th>Count</th>
        <th>Des</th>
        <th>From User Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cashIncomes as $cashIncome)
        <tr>
            <td>{!! $cashIncome->user_id !!}</td>
            <td>{!! $cashIncome->type !!}</td>
            <td>{!! $cashIncome->count !!}</td>
            <td>{!! $cashIncome->des !!}</td>
            <td>{!! $cashIncome->from_user_id !!}</td>
            <td>
                {!! Form::open(['route' => ['cashIncomes.destroy', $cashIncome->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('cashIncomes.show', [$cashIncome->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('cashIncomes.edit', [$cashIncome->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>