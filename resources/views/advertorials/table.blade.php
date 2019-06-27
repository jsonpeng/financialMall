<table class="table table-responsive" id="advertorials-table">
    <thead>
        <tr>
            <th>Account</th>
        <th>Content</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($advertorials as $advertorial)
        <tr>
            <td>{!! $advertorial->account !!}</td>
            <td>{!! $advertorial->content !!}</td>
            <td>
                {!! Form::open(['route' => ['advertorials.destroy', $advertorial->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('advertorials.show', [$advertorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('advertorials.edit', [$advertorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>