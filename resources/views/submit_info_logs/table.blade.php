<table class="table table-responsive" id="submitInfoLogs-table">
    <thead>
        <tr>
            <th>编号</th>
            <th>姓名</th>
            <th>手机号</th>
            <th>电话是否半年以上</th>
            <th>是否实名制</th>
            <th>年龄</th>
            <th>有无信用卡[几张]</th>
            <th>是否正常使用</th>
            <th>有无逾期</th>
            <th>是否能提供信用卡账单邮箱6个月以上</th>
            <th>芝麻分多少</th>
            <th>是否是网黑</th>
            <th>最近有无频繁网贷</th>
            <th>有无稳定工作</th>
            <th>有无社保</th>
            <th>有无公积金</th>
            <th>是否是学生</th>
            <th>学信网是否能查到吗</th>
            <th>DK事项和流程是否了解</th>
            <th>提交时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($submitInfoLogs as $submitInfoLog)
        <tr>
            <td>{!! $submitInfoLog->id !!}</td>
            <td>{!! $submitInfoLog->name !!}</td>
            <td>{!! $submitInfoLog->mobile !!}</td>
            <td>{!! $submitInfoLog->whether_mobile_lg_half_year !!}</td>
            <td>{!! $submitInfoLog->whether_shimingzhi !!}</td>
            <td>{!! $submitInfoLog->age !!}</td>
            <td>{!! $submitInfoLog->whether_has_xycard !!}</td>
            <td>{!! $submitInfoLog->whether_normal_use !!}</td>
            <td>{!! $submitInfoLog->whether_has_delay !!}</td>
            <td>{!! $submitInfoLog->whether_give_xycard_log !!}</td>
            <td>{!! $submitInfoLog->zhimafen !!}</td>
            <td>{!! $submitInfoLog->whether_is_wanghei !!}</td>
            <td>{!! $submitInfoLog->whether_wangdai !!}</td>
            <td>{!! $submitInfoLog->whether_had_job !!}</td>
            <td>{!! $submitInfoLog->whether_has_shebao !!}</td>
            <td>{!! $submitInfoLog->whether_has_gongjijin !!}</td>
            <td>{!! $submitInfoLog->whether_is_student !!}</td>
            <td>{!! $submitInfoLog->whether_has_xuexinwang !!}</td>
            <td>{!! $submitInfoLog->whether_know_dk !!}</td>
            <td>{!! $submitInfoLog->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['submitInfoLogs.destroy', $submitInfoLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                  {{--   <a href="{!! route('submitInfoLogs.show', [$submitInfoLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('submitInfoLogs.edit', [$submitInfoLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>