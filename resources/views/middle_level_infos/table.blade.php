<table class="table table-responsive" id="middleLevelInfos-table">
    <thead>
        <tr>
            <th>标题</th>
            <th>课程分类</th>
            <th>类型</th>
            <th>会员等级</th>
            <th>赠送积分</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($middleLevelInfos as $middleLevelInfo)
        <tr>
            <td>{!! $middleLevelInfo->title !!}</td>
            <td>{!!  $middleLevelInfo->CatName !!}</td>
            <td>{!! $middleLevelInfo->type !!}</td>
            <td>{!! $middleLevelInfo->level !!}</td>
            <td>{!! $middleLevelInfo->jifen !!}</td>
            <td>
                {!! Form::open(['route' => ['middleLevelInfos.destroy', $middleLevelInfo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                  {{--   <a href="{!! route('middleLevelInfos.show', [$middleLevelInfo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('middleLevelInfos.edit', [$middleLevelInfo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>