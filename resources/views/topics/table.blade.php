<table class="table table-responsive" id="topics-table">
    <thead>
        <tr>
        <th>试题序号</th>
        <th>试题名称</th>
       
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($topics as $topics)
        <?php 
        $select = app('commonRepo')->selectionsTopicRepo()->topicSelects($topics->id);
        $answer =app('commonRepo')->selectionsTopicRepo()->topicSelects($topics->id,1);
         ?>
        <tr>
            <td>{!! $topics->sort !!}</td>
            <td>{!! $topics->name !!}</td>
            <td>
                {!! Form::open(['route' => ['topics.destroy', $paper->id,$topics->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('selectionsTopics.index',$topics->id) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i>管理选项</a>
                    <a href="{!! route('topics.edit', [$paper->id,$topics->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>

        @if(count($select))
          
        
                <tr><td> @foreach($select as $item) {!! a_link($item->type,'javascript:;') !!} {{ $item->content }}  @if($item->is_result)  {!! a_link('(√)','javascript:;','red') !!} @endif @endforeach </td></tr>
          
           


        @endif
    @endforeach
    </tbody>
</table>