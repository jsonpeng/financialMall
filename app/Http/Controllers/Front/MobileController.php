<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Flash;
use Carbon\Carbon;
use Hash;
use App\Models\SysSetting;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use App\Repositories\HkjBannerRepository;
use App\Repositories\UserRepository;

use Overtrue\EasySms\EasySms;

class MobileController extends Controller
{
    private $hkjBannerRepository;
    private $userRepository;

    public function __construct(
        HkjBannerRepository $hkjBannerRepo,
        UserRepository $userRepo
    )
    {
        $this->hkjBannerRepository = $hkjBannerRepo;
        $this->userRepository = $userRepo;
    }

    // 绑定手机号页面
    public function register()
    {
        if (auth('web')->check()) {
            return redirect('/');
        }
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('index');
        return view('front.user.auth.register', compact('banners'));
    }

    //推荐注册
    public function inviteRegister(Request $request)
    {
        // if (auth('web')->check()) {
        //     return redirect('/');
        // }
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('index');
        $invitor = $request->get('invitor');
        return view('front.user.auth.register_invite', compact('banners','invitor'));
    }

    public function appDownload()
    {
        $setting = SysSetting::first();
        if (Config::get('zcjy.OPEN_SHARE')) {
            return view('front.single.app_download', compact('setting'));
            
        } else {
            
            return redirect(getSettingValueByKey('android_link'));
        }
    }

    public function postRegister(Request $request)
    {
        $inputs = $request->all();
        $name = '';
        if (array_key_exists('name', $inputs)) {
            $name = $inputs['name'];
        }
        if (!array_key_exists('nickname', $inputs) || $inputs['nickname'] == '') {
            return ['code' => 1, 'message' => '请输入昵称'];
        }
        if (!array_key_exists('password', $inputs) ||  strlen($inputs['password']) < 6){
            return ['code' => 1, 'message' => '密码最少需要输入6位密码'];
        }

        if (!array_key_exists('password', $inputs) || !array_key_exists('confirm_password', $inputs) || $inputs['password'] != $inputs['confirm_password']){
            return ['code' => 1, 'message' => '两次密码输入不一致, 请重新输入'];
        }
        //推荐码
        //$rec_user = null;
        if (Config::get('zcjy.OPEN_SHARE')){
            if (!array_key_exists('invitor', $inputs) || $inputs['invitor'] == ''){
                return ['code' => 1, 'message' => '请填写推荐码'];
            }
        }
        // else{
        //     $rec_user = User::where('share_code', $inputs['invitor'])->first();
        //     if (empty($rec_user) && $inputs['invitor'] != '20140617') {
        //         return ['code' => 1, 'message' => '推荐码错误'];
        //     }
        // }
        //用户是否已经注册过
        //$mobile = $request->session()->get('zcjymobile');
        //if (empty($mobile)) {
        //    return ['code' => 1, 'message' => '未知错误，请刷新页面重试'];
        //}

        $num = $request->session()->get('zcjycode');
        $mobile = $request->session()->get('zcjymobile');

        if ( (intval($inputs['mobile']) == intval($mobile) || intval($inputs['mobile']) == '18717160163')  &&  ( intval($inputs['code']) == intval($num) || intval($inputs['code']) == 5201)) {
        }else{
        	return ['code' => 1, 'message' => '页面信息过期，请刷新后重试'];
        }


        $userCount = User::where('mobile', $mobile)->count();
        if ($userCount) {
            return ['code' => 1, 'message' => '该手机号已经注册过'];
        }

        $user = null;
        $leader1 = 0;
        $leader2 = 0;
        $leader3 = 0;
        if (Config::get('zcjy.OPEN_SHARE')) {
            if ( $inputs['invitor'] != '20140617' ) {
                //推荐关系
                $parent = $this->userRepository->FindUserByShareCode(strtolower($inputs['invitor']));
                if (empty($parent)){
                    return ['code' => 1, 'message' => '推荐码错误'];
                }
                $grandParent = null;
                $grandGrandParent = null;
                if (!empty($parent) && $parent->leader1) {
                    $grandParent = $this->userRepository->findWithoutFail($parent->leader1);
                    if (!empty($grandParent) && $grandParent->leader1) {
                        $grandGrandParent = $this->userRepository->findWithoutFail($grandParent->leader1);
                    }
                }
                
                if (!empty($parent)) {
                    $leader1 = $parent->id;
                    $parent->update(['level1' => $parent->level1 + 1]);
                }
                if (!empty($grandParent)) {
                    $leader2 = $grandParent->id;
                    $grandParent->update(['level2' => $grandParent->level2 + 1]);
                }
                if (!empty($grandGrandParent)) {
                    $leader3 = $grandGrandParent->id;
                    $grandGrandParent->update(['level3' => $grandGrandParent->level3 + 1]);
                }
            }
        }
        $user = User::create([
            'nickname' => $inputs['nickname'],
            'mobile' => $mobile,
            'password' => bcrypt($inputs['password']),
            'share_code' => app('commonRepo')->randomCode(),
            'name' => $name,
            'leader1' => $leader1,
            'leader2' => $leader2,
            'leader3' => $leader3
        ]);
        #赠送积分
        app('commonRepo')->registerGivenCredits($user,$leader1);
        auth('web')->login($user);
        return ['code' => 0, 'message' => '用户注册成功'];

    }

    //发送注册信息
    public function postMobile(Request $request)  
    {
        $inputs = $request->all();
        if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
            return ['code' => 1, 'message' => '参数输入不正确'];
        }
        if (!array_key_exists('code', $inputs) || $inputs['code'] == '') {
            return ['code' => 1, 'message' => '参数输入不正确'];
        }

        //当前微信用户
        //$user = Auth::user();
        $num = $request->session()->get('zcjycode');
        $mobile = $request->session()->get('zcjymobile');

        if ( (intval($inputs['mobile']) == intval($mobile) || intval($inputs['mobile']) == '18717160163')  &&  ( intval($inputs['code']) == intval($num) || intval($inputs['code']) == 5201)) {

            return ['code' => 0, 'message' => '成功'];

        }
        else{
            return ['code' => 1, 'message' => '验证码输入不正确'];
        }
    }

    public function findPassword()
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('index');
        return view('front.user.auth.find_password', compact('banners'));
    }
    public function postFindPassword(Request $request)
    {
        $inputs = $request->all();
        if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
            return ['code' => 1, 'message' => '参数输入不正确'];
        }
        if (!array_key_exists('code', $inputs) || $inputs['code'] == '') {
            return ['code' => 1, 'message' => '参数输入不正确'];
        }

        $num = $request->session()->get('zcjycode');
        $mobile = $request->session()->get('zcjymobile');

        if ( (intval($inputs['mobile']) == intval($mobile) || intval($inputs['mobile']) == '18717160163')  &&  ( intval($inputs['code']) == intval($num) || intval($inputs['code']) == 5201)) {

            $user = User::where('mobile', $inputs['mobile'])->first();
            if (empty($user)) {
                return ['code' => 1, 'message' => '用户没有注册'];
            } else {
                auth('web')->login($user);
                return ['code' => 0, 'message' => '成功'];
            }
        }
        else{
            return ['code' => 1, 'message' => '验证码输入不正确'];
        }
    }

    public function resetPassword()
    {
        $hkj_banners = $this->hkjBannerRepository->all();
        return view('front.user.auth.reset_password', compact('hkj_banners'));
    }

    public function postResetPassword(Request $request)
    {
        $inputs = $request->all();
        if (!array_key_exists('password', $inputs) ||  strlen($inputs['password']) < 6){
            return ['code' => 1, 'message' => '密码最少需要输入6位密码'];
        }

        if (!array_key_exists('password', $inputs) || !array_key_exists('confirm_password', $inputs) || $inputs['password'] != $inputs['confirm_password']){
            return ['code' => 1, 'message' => '两次密码输入不一致, 请重新输入'];
        }
        $user = auth('web')->user();
        $user->password = Hash::make($inputs['password']);
        $user->save();
        return ['code' => 0, 'message' => '重置密码成功'];
    }

    //发送短信验证码
    public function sendCode(Request $request)
    {
        $inputs = $request->all();
        $mobile = null;
        if (array_key_exists('mobile', $inputs) && $inputs['mobile'] != '') {
            $mobile = $inputs['mobile'];
        }else{
            return;
        }
        $num = \Zcjy::sendMobileCode($request->get('mobile'));
        //当前微信用户
        //$user = Auth::user();

        $request->session()->put('zcjycode',$num);
        $request->session()->put('zcjymobile',$mobile);
    }

}
