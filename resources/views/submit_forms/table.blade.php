<table class="table table-responsive" id="submitForms-table">
    <thead>
        <tr>
            <th>类型</th>
            <th>姓名</th>
            <th>电话</th>
            <th>申请日期</th>
            <th colspan="3">查看</th>
        </tr>
    </thead>
    <tbody>
    @foreach($submitForms as $submitForm)
        <tr>
            <td>{!! $submitForm->type !!}</td>
            <td>{!! $submitForm->user_name !!}</td>
            <td>{!! $submitForm->mobile !!}</td>
            <td>{!! $submitForm->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['submitForms.destroy', $submitForm->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('submitForms.show', [$submitForm->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {{-- <a href="{!! route('submitForms.edit', [$submitForm->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>