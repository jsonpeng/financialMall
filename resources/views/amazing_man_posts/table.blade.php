<table class="table table-responsive" id="amazingManPosts-table">
    <thead>
        <tr>
            <th>Admin Id</th>
        <th>Post Id</th>
        <th>Type</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($amazingManPosts as $amazingManPost)
        <tr>
            <td>{!! $amazingManPost->admin_id !!}</td>
            <td>{!! $amazingManPost->post_id !!}</td>
            <td>{!! $amazingManPost->type !!}</td>
            <td>
                {!! Form::open(['route' => ['amazingManPosts.destroy', $amazingManPost->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('amazingManPosts.show', [$amazingManPost->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('amazingManPosts.edit', [$amazingManPost->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>