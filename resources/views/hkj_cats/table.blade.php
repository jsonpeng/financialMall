<table class="table table-responsive" id="hkjCats-table">
    <thead>
        <tr>
            <th>分类名称</th>
            {{-- <th>图片</th> --}}
            <th>排序(权重)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($hkjCats as $hkjCat)
        <tr>
            <td>{!! $hkjCat->name !!}</td>
            {{-- <td><img src="{!! $hkjCat->image !!}" style="height: 25px;"></td> --}}
            <td>{!! $hkjCat->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['hkjCats.destroy', $hkjCat->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('hkjCats.edit', [$hkjCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>