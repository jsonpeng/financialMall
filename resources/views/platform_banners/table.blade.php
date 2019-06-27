<table class="table table-responsive" id="platformBanners-table">
    <thead>
        <tr>
            <th>图片</th>
            <th>链接</th>
            <th>排序(权重)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($platformBanners as $platformBanner)
        <tr>
            <td><img src="{!! $platformBanner->image !!}" style="height: 50px;"></td>
            <td>{!! $platformBanner->link !!}</td>
            <td>{!! $platformBanner->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['platformBanners.destroy', $platformBanner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('platformBanners.edit', [$platformBanner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>