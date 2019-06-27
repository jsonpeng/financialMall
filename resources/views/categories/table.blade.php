<table class="table table-responsive" id="categories-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图片</th>
            <th>排序(权重)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{!! $category->name !!}</td>
            <td>@if(!empty($category->image))<img src="{!! $category->image !!}" style="height: 25px;"> @endif</td>
            <td>{!! $category->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['categoriescat.destroy', $category->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!--a href="{!! route('categoriescat.show', [$category->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a-->
                    <a href="{!! route('categoriescat.edit', [$category->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>