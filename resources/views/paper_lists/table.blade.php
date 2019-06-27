<table class="table table-responsive" id="paperLists-table">
    <thead>
        <tr>
        <th>试卷名称</th>
        {{-- <th>试卷分类</th> --}}
        <th>难度等级</th>
        <th>及格通过分数</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($paperLists as $paperList)
        <?php $type = optional($paperList->type()->first()); ?>
        <tr>
            <td>{!! $paperList->name !!}</td>
            {{-- <td>{!! a_link($type->name,route('paperTypes.edit', [$type->id]))   --}}
           </td>
            <td>{!! $paperList->level !!}</td>
            <td>{!! $paperList->pass_grade !!}</td>
            <td>
                {!! Form::open(['route' => ['paperLists.destroy', $paperList->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                     <a href="{!! route('topics.index', [$paperList->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i>管理试题</a>
                    <a href="{!! route('paperLists.edit', [$paperList->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>