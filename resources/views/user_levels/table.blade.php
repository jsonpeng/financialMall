<table class="table table-responsive" id="userLevels-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>描述</th>
            <th>售价</th>
            <th>会员天数</th>
            <th>会员等级(越高查看权限越高)</th>
            @if (Config::get('zcjy.OPEN_SHARE'))
            <!-- <th>一级提成</th>
            <th>二级提成</th> -->
            @endif
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($userLevels as $userLevel)
        <tr>
            <td>{!! $userLevel->name !!}</td>
            <td>{!! $userLevel->des !!}</td>
            <td>{!! $userLevel->money !!}</td>
            <td>{!! $userLevel->days !!}</td>
            <td>{!! $userLevel->level !!}</td>
            @if (Config::get('zcjy.OPEN_SHARE'))
        <!--     <td>{!! $userLevel->level_money_11 !!}</td>
            <td>{!! $userLevel->level_money_12 !!}</td> -->
            @endif
            <td>
                {!! Form::open(['route' => ['userLevels.destroy', $userLevel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('userLevels.edit', [$userLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗? 不可恢复')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @if(!is_null($userLevel->attach_words))
        <?php $attach_words = spaceList($userLevel->attach_words); ?>
            @foreach ($attach_words as $word)
               <tr> 
                <td>&nbsp;&nbsp;&nbsp;<strong>·{!! $word !!}</strong></td>
               </tr>
            @endforeach 
        @endif
    @endforeach
    </tbody>
</table>