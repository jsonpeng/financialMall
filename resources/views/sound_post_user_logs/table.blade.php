<table class="table table-responsive" id="soundPostUserLogs-table">
    <thead>
        <tr>
            <th>User Id</th>
        <th>Last See Time</th>
        <th>Sound Post Id</th>
        <th>Whether End</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($soundPostUserLogs as $soundPostUserLog)
        <tr>
            <td>{!! $soundPostUserLog->user_id !!}</td>
            <td>{!! $soundPostUserLog->last_see_time !!}</td>
            <td>{!! $soundPostUserLog->sound_post_id !!}</td>
            <td>{!! $soundPostUserLog->whether_end !!}</td>
            <td>
                {!! Form::open(['route' => ['soundPostUserLogs.destroy', $soundPostUserLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('soundPostUserLogs.show', [$soundPostUserLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('soundPostUserLogs.edit', [$soundPostUserLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>