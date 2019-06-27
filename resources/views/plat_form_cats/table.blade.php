<table class="table table-responsive" id="platFormCats-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图片</th>
            <th>排序(权重)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($platFormCats as $platFormCat)
        <tr>
            <td>{!! $platFormCat->name !!}</td>
            <td><img src="{!! $platFormCat->image !!}" style="height: 25px;"></td>
            <td>{!! $platFormCat->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['platFormCats.destroy', $platFormCat->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('platFormCats.edit', [$platFormCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>