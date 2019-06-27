<table class="table table-responsive" id="testRecords-table">
    <thead>
        <tr>
        <th>用户</th>
        <th>试卷名称</th>
        {{-- <th>试卷分类</th> --}}
        <th>答题数量</th>
        <th>是否通过</th>
        <th>分数</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($testRecords as $testRecords)
    <?php 
    $paper = optional($testRecords->paper()->first());
    $paper_type = optional($testRecords->papertype()->first());
    ?>
        <tr>
            <td>{!! $testRecords->user_id !!}</td>
            <td>{!! $paper->name !!}</td>
            {{-- <td>{!! $paper_type->name !!}</td> --}}
            <td>{!! $testRecords->topic_num !!}</td>
            <td>{!! empty($testRecords->is_pass) ? '否' : '是' !!}</td>
            <td>{!! $testRecords->grade !!}</td>
            <td>
                {!! Form::open(['route' => ['testRecords.destroy', $testRecords->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
             {{--        <a href="{!! route('testRecords.show', [$testRecords->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('testRecords.edit', [$testRecords->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>