<table class="table table-responsive" id="hkjBanners-table">
    <thead>
        <tr>
            <th>图片</th>
            <th>链接</th>
            <th>排序(权重)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($hkjBanners as $hkjBanner)
        <tr>
            <td><img src="{{ asset( $hkjBanner->image) }}" style="height: 100px; width: auto;"></td>
            <td>{!! $hkjBanner->link !!}</td>
            <td>{!! $hkjBanner->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['hkjBanners.destroy', $hkjBanner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!--a href="{!! route('hkjBanners.show', [$hkjBanner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a-->
                    <a href="{!! route('hkjBanners.edit', [$hkjBanner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>