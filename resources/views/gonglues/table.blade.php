<table class="table table-responsive" id="gonglues-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图标</th>
            <th>排序</th>
            <th>发布</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($gonglues as $gonglue)
        <tr>
            <td>{!! $gonglue->name !!}</td>
            <td><img src="{!! $gonglue->image !!}" style="height: 25px; width: auto;"></td>
            <td>{!! $gonglue->sort !!}</td>
            <td>{!! $gonglue->shelf !!}</td>
            <td>
                {!! Form::open(['route' => ['gonglues.destroy', $gonglue->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('gonglues.show', [$gonglue->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('gonglues.edit', [$gonglue->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>