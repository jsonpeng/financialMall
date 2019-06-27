<table class="table table-responsive" id="posIntros-table">
    <thead>
        <tr>
            <th>Intro</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posIntros as $posIntro)
        <tr>
            <td>{!! $posIntro->intro !!}</td>
            <td>
                {!! Form::open(['route' => ['posIntros.destroy', $posIntro->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('posIntros.show', [$posIntro->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('posIntros.edit', [$posIntro->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>