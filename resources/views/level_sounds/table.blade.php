<table class="table table-responsive" id="levelSounds-table">
    <thead>
        <tr>
            <th>Level Info Id</th>
        <th>Sound Post Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($levelSounds as $levelSound)
        <tr>
            <td>{!! $levelSound->level_info_id !!}</td>
            <td>{!! $levelSound->sound_post_id !!}</td>
            <td>
                {!! Form::open(['route' => ['levelSounds.destroy', $levelSound->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('levelSounds.show', [$levelSound->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('levelSounds.edit', [$levelSound->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>