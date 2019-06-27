<table class="table table-responsive" id="attachUserLevels-table">
    <thead>
        <tr>
            <th>User Id</th>
        <th>Level Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($attachUserLevels as $attachUserLevel)
        <tr>
            <td>{!! $attachUserLevel->user_id !!}</td>
            <td>{!! $attachUserLevel->level_id !!}</td>
            <td>
                {!! Form::open(['route' => ['attachUserLevels.destroy', $attachUserLevel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('attachUserLevels.show', [$attachUserLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('attachUserLevels.edit', [$attachUserLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>