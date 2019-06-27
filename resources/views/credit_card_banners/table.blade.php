<table class="table table-responsive" id="creditCardBanners-table">
    <thead>
        <tr>
            <th>图片</th>
            <th>链接</th>
            <th>排序(权重)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($creditCardBanners as $creditCardBanner)
        <tr>
            <td><img src="{!! $creditCardBanner->image !!}" style="height: 50px;"></td>
            <td>{!! $creditCardBanner->link !!}</td>
            <td>{!! $creditCardBanner->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['creditCardBanners.destroy', $creditCardBanner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('creditCardBanners.edit', [$creditCardBanner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>