<table class="table table-responsive" id="creditCards-table">
    <thead>
        <tr>
            <th>信用卡名称</th>
            <th>银行</th>
            {{-- <th>主题</th> --}}
            <th style="width: 250px;">简介</th>
            <th>图片</th>
            <th>浏览量</th>
            <th>热门</th>
            <th>添加时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($creditCards as $creditCard)
        <tr>
            <td>{!! $creditCard->name !!}</td>
            <td>{!! $creditCard->bank->name !!}</td>
            {{-- <td>{!! $creditCard->theme->name !!}</td> --}}
            <td>{!! $creditCard->brief !!}</td>
            <td><img src="{!! $creditCard->image !!}" style="height: 25px;"></td>
            <td>{!! $creditCard->view !!}</td>
            <td>{!! $creditCard->isHot !!}</td>
            <td>{!! $creditCard->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['creditCards.destroy', $creditCard->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('creditCards.edit', [$creditCard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>