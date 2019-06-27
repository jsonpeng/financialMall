<table class="table table-responsive" id="bankCards-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Bank Name</th>
        <th>User Name</th>
        <th>Mobile</th>
        <th>Count</th>
        <th>User Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($bankCards as $bankCard)
        <tr>
            <td>{!! $bankCard->name !!}</td>
            <td>{!! $bankCard->bank_name !!}</td>
            <td>{!! $bankCard->user_name !!}</td>
            <td>{!! $bankCard->mobile !!}</td>
            <td>{!! $bankCard->count !!}</td>
            <td>{!! $bankCard->user_id !!}</td>
            <td>
                {!! Form::open(['route' => ['bankCards.destroy', $bankCard->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('bankCards.show', [$bankCard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('bankCards.edit', [$bankCard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>