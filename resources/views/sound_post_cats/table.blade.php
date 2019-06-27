<table class="table table-responsive" id="soundPostCats-table">
    <thead>
        <tr>
            <th>名称</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($soundPostCats as $soundPostCat)
        <tr>
            <td>{!! $soundPostCat->name !!}</td>
            <td>
                {!! Form::open(['route' => ['soundPostCats.destroy', $soundPostCat->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
         {{--            <a href="{!! route('soundPostCats.show', [$soundPostCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('soundPostCats.edit', [$soundPostCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>