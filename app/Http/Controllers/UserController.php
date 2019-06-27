<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\UserLevel;
use App\Models\Level;
use Hash;
use Flash;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        session(['userLevelIndex'=>$request->fullUrl()]);
        $input = $request->all();
        $users = User::where('level', '用户');
        if (array_key_exists('nickname', $input) && $input['nickname'] != "") {
            $users->where('nickname', 'like', '%'.$input['nickname'].'%');
        }
        if (array_key_exists('mobile', $input) && $input['mobile'] != "") {
            $users->where('mobile', 'like', '%'.$input['mobile'].'%');
        }
        if (array_key_exists('member', $input) && $input['member'] != "全部") {
            $isMember = $input['member'] == "是" ? 1 : 0;
            $users->where('member', $isMember)->orderBy('member_buy_time', 'desc');
        }else{
            $users = $users->orderBy('created_at', 'desc');
        }

    	$users = $users->paginate(15);
        $userlevels = UserLevel::all();

        //计算用户的推荐人
        foreach ($users as $key => $value) {
            if ($value->leader1) {
                $parent = User::where('id', $value->leader1)->first();
                if ($parent) {
                    $value['leader1'] = $parent->mobile;
                    $value['leader1_name'] = $parent->name;
                }
            }
        }
        $levels = Level::all();

    	return view('user.index')
        ->with('users', $users)
        ->with('userlevels',$userlevels)
        ->with('levels',$levels)
        ->withInput($input);;
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return redirect('/zcjy/users');
        }

        $userLevel = $user->UserLevel;

        $share_img = null;
    
        // $share_img = app('commonRepo')->userRepo()->erweima($user);
        
        //订单列表
        //$orders = $this->userRepository->orderOfUser($user);
        $orders = \App\Models\Order::where('user_id', $id)->where('order_pay', '已支付')->orderBy('created_at', 'desc')->paginate(18);
        //余额记录
        // $funds = $this->userRepository->moneyLogs($user);
        //积分记录
        $credits = app('commonRepo')->creditLogRepo()->creditLogs($user);
        //通知消息
        // $messages = app('notice')->allNotices($id);
        //currentTime
        return view('user.show', compact('user','userLevel', 'share_img', 'orders', 'credits'));
    }



       //添加用户
    public function create(Request $request){
         $model_required = $this->modelRequiredParam(User::class);
         $levels = app('commonRepo')->AttachUserLevelRepo()->levelAll();
         return view('user.create')
            ->with('model_required',$model_required)
            ->with('levels',$levels);
    }

    //添加用户操作
    public function createAction(Request $request){
        $input = $request->all();

        $varify = $this->varifyInputParamV2($input,User::$rules,'key');
        if($varify){
            return redirect(route('user.create'))
                    ->withErrors($varify)
                    ->withInput($input);
                    
        }
        
        if($input['mobile'] != $input['mobile_enter']){
            return redirect(route('user.create'))
                    ->withErrors('两次手机号不一致')
                    ->withInput($input);
        }

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        app('commonRepo')->AttachUserLevelRepo()->syncSaveUserLevel($input,$user);
        
        Flash::success('添加新用户成功');
        return redirect(session('userLevelIndex'));

    }

    public function updateUserLevel(Request $request,$id)
    {
        $user = User::find($id);

        if(empty($user))
        {
            Flash::error('没有该用户');
            return redirect(session('userLevelIndex'));
        }

        $input = $request->all();

        if(!isset($input['level_id']) || isset($input['level_id']) && $input['level_id'] == 0)
        {
            app('commonRepo')->AttachUserLevelRepo()->deleteUserLevel($user);
            Flash::success('重置成功');
            return redirect(session('userLevelIndex'));
        }

        app('commonRepo')->AttachUserLevelRepo()->syncSaveUserLevel($input,$user,'update');
        Flash::success('修改等级成功');
        return redirect(session('userLevelIndex'));
    }

    
    public function kaitonghuiyuan(Request $request, $id)
    {
        $days = 15;
        if ($request->has('days')) {
            $days = $request->input('days');
        }
    	$user = User::find($id);
    	if (empty($user)) {
    		return ['code' => 1, 'message' => '用户不存在'];
    	}
    	if ($user->member) {
    		$user->update(['member' => 0, 'member_buy_time' => null,'level_name'=>null,'member_end_time' => null,'level_id'=>null]);
    		return ['code' => 0, 'message' => '否'];
    	} else {
            //会员等级
            $userLevel = UserLevel::where('id', $request->input('level'))->first();
            if (empty($userLevel)) {
                return ['code' => 1, 'message' => 'VIP等级不存在'];
            }
    		$user->update([
                'member' => 1, 
                'member_buy_time' => \Carbon\Carbon::now(), 
                'member_end_time' => \Carbon\Carbon::now()->addDays($userLevel->days),
                'mem_level' => $userLevel->level,
                'level_name' => $userLevel->name,
                'can_share' => true,
                'level_id'  => $userLevel->id
            ]);
    		return ['code' => 0, 'message' => '是'];
    	}
    }

    public function kaitongfenxiang(Request $request, $id)
    {
       
        $user = User::find($id);
        if (empty($user)) {
            return ['code' => 1, 'message' => '用户不存在'];
        }

        if ($user->can_share == '是') {
            $user->update(['can_share' => '否']);
            return ['code' => 0, 'message' => '否'];
        } else {
            $user->update(['can_share' => '是']);
            return ['code' => 0, 'message' => '是'];
        }
    }

    public function changeName(Request $request, $id)
    {
        $input = $request->all();
        if (!array_key_exists('name', $input) || empty($input['name'])) {
            return ['code' => 1, 'message' => '请填写姓名'];
        }
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return ['code' => 1, 'message' => '用户不存在'];
        }
        $user->name = $input['name'];
        $user->save();
        return ['code' => 0, 'message' => $user->name];
    }

    public function changeScale(Request $request, $id, $scale)
    {
        $user = User::find($id);
        $newScale = intval($scale);
        $type = $request->input('type');
        switch ($type) {
            case '11':
                $user->level_money_11 = $newScale;
                $user->save();
                break;
            case '12':
                $user->level_money_12 = $newScale;
                $user->save();
                break;
            case '21':
                $user->level_money_21 = $newScale;
                $user->save();
                break;
            case '22':
                $user->level_money_22 = $newScale;
                $user->save();
                break;
            case '31':
                $user->level_money_31 = $newScale;
                $user->save();
                break;
            case '32':
                $user->level_money_32 = $newScale;
                $user->save();
                break;
            
            default:
                return ['code' => 1, 'message' => '参数不正确'];
                break;
        }
        // if ($newScale > 70) {
        //     $newScale = 70;
        // }
        // if ($newScale < 0) {
        //     $newScale = 0;
        // }
        // $user->update(['scale' => $newScale]);
        return ['code' => 0, 'message' => $newScale];
    }

    // public function changeScale2(Request $request, $id, $scale)
    // {
    //     $user = User::find($id);
    //     $newScale = intval($scale);
    //     if ($newScale > 20) {
    //         $newScale = 20;
    //     }
    //     if ($newScale < 0) {
    //         $newScale = 0;
    //     }
    //     $user->update(['scale_level2' => $newScale]);
    //     return ['code' => 0, 'message' => $newScale];
    // }

    public function setLeader(Request $request, $id)
    {
        if (!$request->has('code')) {
            return ['code' => 1, 'message' => '请输入推荐码'];
        }
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return ['code' => 1, 'message' => '用户不存在'];
        }
        $parent = User::where('share_code', $request->input('code'))->first();
        if (empty($parent)) {
            return ['code' => 1, 'message' => '推荐码不存在'];
        }
        //一级推荐人
        $user->leader1 = $parent->id;
        //二级推荐人
        if ($parent->leader1) {
            $user->leader2 = $parent->leader1;
        }
        $user->save();

        $parent->level1 += 1;
        $parent->save();

        return ['code' => 0, 'message' => '成功'];
    }

    /**
     * 修改用户积分
     * @Author   HipePeng
     * @DateTime 2018-03-19
     * @UpdateTime
     * @param   ($user_id,$credits_change)[用户id,积分变动值]
     * @return  (code,message)            [code=>0成功1失败,操作后的提示消息]
     */
    public function updateUserCredits(Request $request,$user_id)
    {
       $user = User::find($user_id);
       $credits_change=(float)$request->input('credits_change');

       $credits_final=(float)($user->credits)+$credits_change;

       if(!empty($user)){
           if($credits_final<0){
                return ['code'=>1,'message'=> getSettingValueByKeyCache('credits_alias').'变动后不能为负数'];
            }
            $user->update([
            'credits'=>$credits_final
            ]);
            $detail='管理员操作变动'.getSettingValueByKeyCache('credits_alias').':'.$credits_change;
          app('commonRepo')->addCreditLog($credits_final,$credits_change,$detail,4,$user_id);
          return ['code'=>0,'message'=>'操作成功'];
        }else{
          return ['code'=>1,'message'=>'没有该用户'];
        }
    }
    
}
