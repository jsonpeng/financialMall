<table class="table table-responsive" id="hkjs-table">
    <thead>
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>发布人</th>
            <th>分类</th>
            <th>级别</th>
            <th>免费浏览</th>
            <th>热门</th>
            <th>图片</th>
            <th>浏览量</th>
            <th>创建日期</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($hkjs as $hkj)
        <tr>
            <td>{!! $hkj->id !!}</td>
            <td>{!! $hkj->name !!}</td>
            <td>{!! app('commonRepo')->AmazingManPostRepo()->publishManName($hkj->id,'hkj') !!}</td>
            <td>{!! optional($hkj->cat)->name !!}</td>
            <td>{!! $hkj->level_name !!}</td>
            <td>{!! $hkj->free !!}</td>
            <td>{!! $hkj->isHot !!}</td>
            <td><img src="{!! $hkj->image !!}" style="height: 25px;"></td>
            <th>{!! $hkj->view !!}</th>
            <th>{!! $hkj->created_at !!}</th>
            <td>
                {!! Form::open(['route' => ['hkjs.destroy', $hkj->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="javascript:;" class='btn btn-default btn-xs' onclick="refreshDate({!! $hkj->id !!})"><i class="glyphicon glyphicon-refresh"></i></a>
                    <a href="{!! route('hkjs.edit', [$hkj->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                
                    

                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>