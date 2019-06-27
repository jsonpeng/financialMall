<table class="table table-responsive" id="platForms-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>分类</th>
            <th>图片</th>
            <th>评级</th>
            {{-- <th>特点</th> --}}
            <th>权重</th>
            <th>热门</th>
            <th>创建日期</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($platForms as $platForm)
        <tr>
            <td>{!! $platForm->name !!}</td>
            <td>{!! optional($platForm->cat)->name !!}</td>
            <td><img src="{!! $platForm->image !!}" style="height: 25px;"></td>
            <td>{!! $platForm->star !!}</td>
            {{-- <td>{!! $platForm->remark !!}</td> --}}
            <td>{!! $platForm->sort !!}</td>
            <td>{!! $platForm->isHot !!}</td>
            <td>{!! $platForm->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['platForms.destroy', $platForm->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('platForms.edit', [$platForm->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>