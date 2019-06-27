<table class="table table-responsive" id="jifenRecords-table">
    <thead>
        <tr>
            <th>Oemchannelid</th>
        <th>Clientno</th>
        <th>Channeltagid</th>
        <th>Content</th>
        <th>Type</th>
        <th>Money All</th>
        <th>Money User</th>
        <th>Money Level1</th>
        <th>Money Level2</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($jifenRecords as $jifenRecord)
        <tr>
            <td>{!! $jifenRecord->oemChannelId !!}</td>
            <td>{!! $jifenRecord->clientNo !!}</td>
            <td>{!! $jifenRecord->channelTagId !!}</td>
            <td>{!! $jifenRecord->content !!}</td>
            <td>{!! $jifenRecord->type !!}</td>
            <td>{!! $jifenRecord->money_all !!}</td>
            <td>{!! $jifenRecord->money_user !!}</td>
            <td>{!! $jifenRecord->money_level1 !!}</td>
            <td>{!! $jifenRecord->money_level2 !!}</td>
            <td>
                {!! Form::open(['route' => ['jifenRecords.destroy', $jifenRecord->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('jifenRecords.show', [$jifenRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('jifenRecords.edit', [$jifenRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>