<table class="table table-responsive" id="shareDks-table">
    <thead>
        <tr>
            <th>平台名称</th>
            <th>通道Id</th>
            <th>名称</th>
            <th>类型</th>
            <th>上架</th>
            <th>图标</th>
            <th>返佣类型</th>
            <th>结算周期</th>
            <th>一级会员</th>
            <th>二级会员</th>
            <th>三级会员</th>
            <th>申请人数</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($shareDks as $shareDk)
        <tr>
            <td>{!! $shareDk->channel_name !!}</td>
            <td>{!! $shareDk->channel_id !!}</td>
            <td>{!! $shareDk->name !!}</td>
            <td>{!! $shareDk->type !!}</td>
            <td>{!! $shareDk->shelf !!}</td>
            <td><img src="{!! $shareDk->image !!}" alt="" style="width: auto; height: 25px;"></td>
            
            <td>{!! $shareDk->return_type !!}</td>
            <td>{!! $shareDk->period !!}</td>
            <td>{!! $shareDk->money_level1 !!}</td>
            <td>{!! $shareDk->money_level2 !!}</td>
            <td>{!! $shareDk->money_level3 !!}</td>

            <td>{!! $shareDk->applied !!}</td>
            
            <td>
                {!! Form::open(['route' => ['shareDks.destroy', $shareDk->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{!! route('shareDks.show', [$shareDk->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('shareDks.edit', [$shareDk->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>