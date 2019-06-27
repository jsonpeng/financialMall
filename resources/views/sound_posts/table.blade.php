<table class="table table-responsive" id="soundPosts-table">
    <thead>
        <tr>
            <th style="width: 30%;">名称</th>
            <th>系列分类</th>
            <th>发布人</th>
            {{-- <th>级别</th> --}}
            {{-- <th>免费浏览</th> --}}
            <th>图片</th>
            <th>浏览量</th>
            <th>创建日期</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($soundPosts as $soundPost)
        <tr>
            <td>{!! $soundPost->name !!}</td>
            <td>{!! optional($soundPost->cat)->name !!}</td>
            <td>{!! app('commonRepo')->AmazingManPostRepo()->publishManName($soundPost->id,'soundPost') !!}</td>
            {{-- <td>{!! $soundPost->level_name !!}</td> --}}
            {{-- <td>{!! $soundPost->free_info !!}</td> --}}
            <td><img src="{!! $soundPost->image !!}" style="height: 25px;"></td>
            <th>{!! $soundPost->view !!}</th>
            <th>{!! $soundPost->created_at !!}</th>
            <td>
                {!! Form::open(['route' => ['soundPosts.destroy', $soundPost->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
        {{--             <a href="{!! route('soundPosts.show', [$soundPost->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('soundPosts.edit', [$soundPost->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>