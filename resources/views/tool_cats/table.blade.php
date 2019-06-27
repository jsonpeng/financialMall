<table class="table table-responsive" id="toolCats-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>别名</th>
            <th>排序</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($toolCats as $toolCat)
        <tr>
            <td>{!! $toolCat->name !!}</td>
            <td>{!! $toolCat->slug !!}</td>
            <td>{!! $toolCat->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['toolCats.destroy', $toolCat->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('toolCats.show', [$toolCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('toolCats.edit', [$toolCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>