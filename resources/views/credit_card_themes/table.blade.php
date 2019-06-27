<table class="table table-responsive" id="creditCardThemes-table">
    <thead>
        <tr>
            <th>主题</th>
            <th>图标</th>
            <th>简介</th>
            <th>排序</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($creditCardThemes as $creditCardTheme)
        <tr>
            <td>{!! $creditCardTheme->name !!}</td>
            <td><img src="{!! $creditCardTheme->image !!}" style="height: 25px;"></td>
            <td>{!! $creditCardTheme->brief !!}</td>
            <td>{!! $creditCardTheme->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['creditCardThemes.destroy', $creditCardTheme->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('creditCardThemes.show', [$creditCardTheme->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('creditCardThemes.edit', [$creditCardTheme->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 删除操作不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>