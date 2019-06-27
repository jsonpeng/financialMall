<table class="table table-responsive" id="paperTypes-table">
    <thead>
        <tr>
            <th>试题分类名称</th>
            <th>需要会员等级</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($paperTypes as $paperType)
        <tr>
            <td>{!! $paperType->name !!}</td>
            <td>{!! $paperType->level !!}</td>
            <td>
                {!! Form::open(['route' => ['paperTypes.destroy', $paperType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                   {{--  <a href="{!! route('paperTypes.show', [$paperType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('paperTypes.edit', [$paperType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>