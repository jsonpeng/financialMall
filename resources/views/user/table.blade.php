<style type="text/css">
    .scale_edit_wrapper, .scale2_edit_wrapper{
        display: none;
    }
</style>

<table class="table table-responsive" id="orders-table">
    <thead>
        <tr>
            {{-- <th class="hidden-xs">ID</th> --}}
            <th class="hidden-xs">昵称</th>
            <th class="hidden-xs">姓名</th>
            <th>会员等级</th>
            <th>积分余额</th>
            <th>电话</th>
            @if (Config::get('zcjy.OPEN_SHARE'))
            <th class="hidden-xs">推荐人</th>
            <th class="hidden-xs">推荐人</th>
            @endif
            <th class="hidden-xs">注册时间</th>
            {{-- <th class="hidden-xs">购买时间</th> --}}
            <th>操作</th>
            @if (Config::get('zcjy.OPEN_SHARE'))
            <th>分享资格</th>
         
      {{--       <th width="100px">初级一级</th>
            <th width="100px">初级二级</th>
            <th width="100px">中级一级</th>
            <th width="100px">中级二级</th>
            <th width="100px">高级一级</th>
            <th width="100px">高级二级</th> --}}
            <th>已提</th>
            <th>待提</th>
            <th>账户余额</th>
            <th>累计奖励</th>
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <!--td><img src="{!! $user->header !!}" style="height: 30px;"></td-->
            {{-- <td class="hidden-xs">{!! $user->id !!}</td> --}}
            <td class="hidden-xs">{!! $user->nickname !!} @if($user->level_name) ({{ $user->level_name }}) @endif</td>
            <td class="hidden-xs">
                <div id="name_{{$user->id}}">
                    <span>{{$user->name}}</span>
                    @if (Config::get('zcjy.OPEN_SHARE'))
                    <div class="btn-group label label-primary" onclick="editName({{$user->id}})">修改</div>
                    @endif
                </div>
                @if (Config::get('zcjy.OPEN_SHARE'))
                <div id="name_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="name_new_{{$user->id}}" type="text" name="newName" value ="{{$user->name}}" style="width: 80px;">
                    <div class="btn-group label label-primary" onclick="saveNewName({{$user->id}}, '11')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewName({{$user->id}}, '11')">取消</div>
                </div>
                @endif
            </td>
              <td>{!! app('commonRepo')->AttachUserLevelRepo()->userLevelName($user) !!} {!! Form::open(['route' => ['user.update_level',$user->id],'method' => 'POST','class'=>'updateLevelF']) !!}   
                <select name="level_id" class="form-control updateLevelS">
                    <option value="0">取消会员等级</option>
                    @foreach($levels as $level)
                     <option value="{!! $level->id !!}">{!! $level->name !!}</option>
                    @endforeach
                </select>  <button type="submit" class='btn btn-default btn-xs'>确认</button> {!! Form::close() !!}<a href="javascript:;" class='btn btn-default btn-xs updateLevelBtn'>修改</a></td>
            <td>{!! $user->credits !!}</td>
            <td>{!! $user->mobile !!}</td>
            @if (Config::get('zcjy.OPEN_SHARE'))
            <td class="hidden-xs">@if($user->leader1_name) {!! $user->leader1_name !!}  @endif</td>
            <td class="hidden-xs">@if($user->leader1) {!! $user->leader1 !!}  @else <span onclick="changeLeader({{ $user->id }})">设置</span> @endif</td>
            @endif
            
            
            <td class="hidden-xs">{!! $user->created_at !!}</td>
            {{-- <td class="hidden-xs" id="member_time_{{ $user->id }}">{!! $user->member_buy_time !!}</td> --}}
            
            {{-- <td id="member_status_{{$user->id}}">{!! $user->isMember !!} </td> --}}
            <td>
               <div class='btn-group'>
                    <a href="{!! route('user.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <div id="member_change_{{$user->id}}" class='label @if($user->member) label-danger @else label-success @endif' onclick="changeMemberStatus({{$user->id}})">@if($user->member)取消会员@else成为会员@endif</div>
                </div>
            </td>

            @if (Config::get('zcjy.OPEN_SHARE'))
            <td><div id="member_share_{{$user->id}}" class='btn-group label @if($user->can_share == '否') label-success @else label-danger @endif' onclick="changeShareStatus({{$user->id}})">{{ $user->can_share }}</div>
            </td>
          
            
{{-- 
            <td>
                <div id="scale11_{{$user->id}}"><span>@if($user->level_money_11) {{$user->level_money_11}} @else 默认 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}}, '11')">修改</div></div>
                <div id="scale11_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale11_new_{{$user->id}}" type="number" name="newScale" @if($user->level_money_11) value = {{$user->level_money_11}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}}, '11')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}}, '11')">取消</div>
                </div>
            </td>
            <td>
                <div id="scale12_{{$user->id}}"><span>@if($user->level_money_12) {{$user->level_money_12}} @else 默认 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}}, '12')">修改</div></div>
                <div id="scale12_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale12_new_{{$user->id}}" type="number" name="newScale" @if($user->level_money_12) value = {{$user->level_money_12}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}}, '12')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}}, '12')">取消</div>
                </div>
            </td>
            <td>
                <div id="scale21_{{$user->id}}"><span>@if($user->level_money_21) {{$user->level_money_21}} @else 默认 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}}, '21')">修改</div></div>
                <div id="scale21_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale21_new_{{$user->id}}" type="number" name="newScale" @if($user->level_money_21) value = {{$user->level_money_21}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}}, '21')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}}, '21')">取消</div>
                </div>
            </td>
            <td>
                <div id="scale22_{{$user->id}}"><span>@if($user->level_money_22) {{$user->level_money_22}} @else 默认 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}}, '22')">修改</div></div>
                <div id="scale22_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale22_new_{{$user->id}}" type="number" name="newScale" @if($user->level_money_22) value = {{$user->level_money_22}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}}, '22')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}}, '22')">取消</div>
                </div>
            </td>
            <td>
                <div id="scale31_{{$user->id}}"><span>@if($user->level_money_31) {{$user->level_money_31}} @else 默认 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}}, '31')">修改</div></div>
                <div id="scale31_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale31_new_{{$user->id}}" type="number" name="newScale" @if($user->level_money_31) value = {{$user->level_money_31}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}}, '31')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}}, '31')">取消</div>
                </div>
            </td>
            <td>
                <div id="scale32_{{$user->id}}"><span>@if($user->level_money_32) {{$user->level_money_32}} @else 默认 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}}, '32')">修改</div></div>
                <div id="scale32_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale32_new_{{$user->id}}" type="number" name="newScale" @if($user->level_money_32) value = {{$user->level_money_32}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}}, '32')">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}}, '32')">取消</div>
                </div>
            </td> --}}
            
            {{-- <td>
                <div id="scale{{$user->id}}"><span>@if($user->scale) {{$user->scale}} @else 默认比例 @endif</span><div class="btn-group label label-primary" onclick="editScale({{$user->id}})">修改</div></div>
                <div id="scale_edit_{{$user->id}}" class="scale_edit_wrapper">
                    <input id="scale_new_{{$user->id}}" type="number" name="newScale" @if($user->scale) value = {{$user->scale}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale({{$user->id}})">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale({{$user->id}})">取消</div>
                </div>
            </td>
            <td>
                <div id="scale2_{{$user->id}}"><span>@if($user->scale_level2) {{$user->scale_level2}} @else 默认比例 @endif</span><div class="btn-group label label-primary" onclick="editScale2({{$user->id}})">修改</div></div>
                <div id="scale2_edit_{{$user->id}}" class="scale2_edit_wrapper">
                    <input id="scale2_new_{{$user->id}}" type="number" name="newScale2" @if($user->scale_level2) value = {{$user->scale_level2}} @endif style="width: 50px;">
                    <div class="btn-group label label-primary" onclick="saveNewScale2({{$user->id}})">保存</div>
                    <div class="btn-group label label-default" onclick="cancelNewScale2({{$user->id}})">取消</div>
                </div>
            </td> --}}
            <td>{!! $user->moenyDone !!}</td>
            <td>{!! $user->moenyPendding !!}</td>
            <td>{!! $user->money !!}</td>
            <td>{!! $user->money_all !!}</td>
            @endif
            
        </tr>
    @endforeach
    </tbody>
</table>

<div id="userDaySet" style="display: none;">
    <div style='width:350px; padding: 0 15px;height: 100%;'>
        <div style='width:320px;padding: 5px 0px 10px 0px;' class='form-group has-feedback'>
            <label>请选择会员卡:</label>
            <select class="form-control" name="level">
                    <option value="">请选择会员卡</option>
                @foreach ($userlevels as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div> 
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>会员有效期天数:</label>
         
            <input  class='form-control' type='number' name='days' value='15' />
        </div> 
        <button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary' onclick='openMember()'>保存</button>
    </div>
</div>

<div id="setleader" style="display: none;">
    <div style='width:350px; padding: 0 15px;height: 100%;'>
         <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>请输入推荐码:</label>
            <input  class='form-control' type='text' name='sharecode' id="sharecode" value='' />
        </div> 
        <button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary' onclick='saveLeader()'>保存</button>
    </div>
</div>

<style type="text/css">
    .label{cursor: pointer;}
</style>

