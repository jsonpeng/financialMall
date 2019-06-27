<table class="table table-responsive" id="amazingMen-table">
    <thead>
        <tr>
        <th>名称</th>
        {{-- <th>邮箱/账号</th> --}}
        {{-- <th>Password</th> --}}
        <th>图片</th>
        <th>职称</th>
        {{-- <th>Des</th> --}}
        <th>粉丝数</th>
        <th>联系方式</th>
        <th>微信</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($amazingMen as $amazingMan)
        <tr>
            <td>{!! $amazingMan->name !!}</td>
            {{-- <td>{!! $amazingMan->email !!}</td> --}}
        {{--     <td>{!! $amazingMan->email !!}</td>
            <td>{!! $amazingMan->password !!}</td> --}}
            <td><img src='{!! $amazingMan->image !!}' / style="max-width: 100px;height: auto;"></td>
            <td>{!! $amazingMan->job !!}</td>
            {{-- <td>{!! $amazingMan->des !!}</td> --}}
            <td>{!! $amazingMan->fans !!}</td>
            <td>{!! $amazingMan->contact !!}</td>
            <td>{!! $amazingMan->weixin !!}</td>
            <td>
                {!! Form::open(['route' => ['amazingMen.destroy', $amazingMan->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('amazingMen.show', [$amazingMan->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('amazingMen.edit', [$amazingMan->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>