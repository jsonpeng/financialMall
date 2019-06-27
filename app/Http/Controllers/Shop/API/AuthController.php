<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

use App\Models\CouponRule;
use App\Models\PointRule;

use EasyWeChat\Factory;
use Hash;

//use SmsManager;

class AuthController extends Controller
{

    /**
     * 发送短信验证码
     *
     * @SWG\Get(path="/api/shop/user/send_code",
     *   tags={"商城用户常用接口"},
     *   summary="发送短信验证码",
     *   description="发送短信验证码,需要用户提供手机号发送,需要注意获取的验证码可用于登录/注册/重置密码使用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="mobile",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function sendMobileCodeAction(Request $request)
    {
        $code = \Zcjy::sendMobileCode($request->get('mobile'));
        if($code == '发送失败')
        {
              return zcjy_callback_data($code,1);
        }
        \Zcjy::cache()::put('zcjy_user_'.$request->get('mobile'),$code,3);
        return zcjy_callback_data($code);
    }

    /**
     * 商城用户重置密码
     *
     * @SWG\Get(path="/api/shop/user/resetpwd",
     *   tags={"商城用户常用接口"},
     *   summary="用户重置密码",
     *   description="用户重置密码,需要用户提供手机号以及验证码使用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="mobile",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="integer",
     *     description="验证码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="password",
     *     type="string",
     *     description="密码",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'mobile,code,password');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        $user = User::where('mobile',$input['mobile'])->first();

        if(empty($user))
        {
            return zcjy_callback_data('该手机号不存在',1);
        }

        #检查验证码
        if(Cache::get('zcjy_user_'.$input['mobile']) != $input['code'])
        {
            return zcjy_callback_data('验证码输入错误',1);
        }

        $user->update(['password' => Hash::make($input['password'])]);

        return zcjy_callback_data('重置密码成功');
    }

    /**
     * 商城用户注册
     *
     * @SWG\Get(path="/api/shop/user/register",
     *   tags={"商城用户常用接口"},
     *   summary="用户注册",
     *   description="用户注册,需要用户提供手机号密码以及验证码使用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="mobile",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="integer",
     *     description="验证码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="password",
     *     type="string",
     *     description="密码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="reg_code",
     *     type="string",
     *     description="推荐码",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function register(Request $request)
    {   
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'mobile,code,password,reg_code');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        #检查一下手机号重复性
        if(User::where('mobile',$input['mobile'])->count())
        {
            return zcjy_callback_data('该手机号已经被注册过',1);
        }

        #检查验证码
        if(Cache::get('zcjy_user_'.$input['mobile']) != $input['code'])
        {
            return zcjy_callback_data('验证码输入错误',1);
        }

        $leader1 = 0;
        if($input['reg_code'] != '20140617')
        {

            $parent = User::where('share_code',$input['reg_code'])->first();

            if(empty($parent))
            {
                return zcjy_callback_data('推荐码输入错误',1);
            }

            $leader1 = $parent->id;
            ##更新parent的level1
            $parent->update(['level1' => $parent->level1 + 1]);
        }

        #创建新用户
        $user = User::create(
            [
            'mobile'     => $input['mobile'],
            'password'   => Hash::make($input['password']),
            'share_code' => app('commonRepo')->randomCode(),
            'leader1'    => $leader1
            ]
        );

        app('commonRepo')->registerGivenCredits($user);

        return zcjy_callback_data('注册成功');
    }




    /**
     * 商城用户登录
     *
     * @SWG\Get(path="/api/shop/user/login",
     *   tags={"商城用户常用接口"},
     *   summary="商城用户登录",
     *   description="商城用户登录,需要用户提供手机号密码使用,需要注意接收返回的data(token)用于后面的接口调用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="mobile",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="登陆方式(传password->手机号+密码登陆,传mobilecode->手机号+验证码登陆),可不填默认登陆方式是手机号+密码登陆",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="string",
     *     description="密码/验证码",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回token用户标识密钥",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function login(Request $request)
    {
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'mobile,code');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        $user = User::where('mobile',$input['mobile'])->first();

        if(empty($user))
        {
            return zcjy_callback_data('该手机号不存在,请先完成注册',1);
        }

        #校检有效性
        if(isset($input['type']) && !in_array($input['type'],['password','mobilecode']))
        {
            return zcjy_callback_data('参数[type]登陆方式错误',1);
        }

        #验证密码
        if(!isset($input['type']) || isset($input['type']) && $input['type'] == 'password')
        {
            if(!Hash::check($input['code'],$user->password))
            {
                return zcjy_callback_data('密码输入错误',1);
            }
        }

        #验证登陆方式
        if(isset($input['type']) && $input['type'] == 'mobilecode')
        {
            #检查验证码
            if(Cache::get('zcjy_user_'.$input['mobile']) != $input['code'])
            {
                return zcjy_callback_data('验证码输入错误',1);
            }
        }

        return zcjy_callback_data(auth()->login($user));
    }

    /**
     * 商城用户退出登录
     *
     * @SWG\Post(path="/api/shop/user/logout",
     *   tags={"商城用户常用接口"},
     *   summary="商城用户退出登录",
     *   description="商城用户退出登录,需要登录后的返回值data(token)字段来调用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();
        return zcjy_callback_data('退出成功');
    }

    /**
     * 商城用户个人信息获取
     *
     * @SWG\Get(path="/api/shop/user/meinfo",
     *   tags={"商城用户常用接口"},
     *   summary="商城用户个人信息获取",
     *   description="商城用户个人信息获取,需要登录后的返回值data(token)字段来调用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回用户信息及会员等级情况(user->用户信息,user_level->会员等级)",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function me(Request $request)
    {
        $user = auth()->user();
        return zcjy_callback_data(['user'=>$user,'user_level'=>$user->UserLevel]);
    }


    /**
     * 商城用户个人信息更新
     *
     * @SWG\Get(path="/api/shop/user/update_info",
     *   tags={"商城用户常用接口"},
     *   summary="商城用户个人信息更新",
     *   description="商城用户个人信息更新,需要登录后的返回值data(token)字段来调用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="nickname",
     *     type="string",
     *     description="昵称 用于昵称修改字段",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="string",
     *     description="姓名 用于支付宝提现使用(使用提现必须配置)",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="header",
     *     type="string",
     *     description="头像 用于修改用户头像 传远程地址",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function updateMeInfo(Request $request)
    {
        $user = auth()->user();
        $this->updateUserLine($user,$request,'nickname,name,header');
        return zcjy_callback_data('更新成功');
    }

    private function updateUserLine($user,$request,$line_arr)
    {
        if(!is_array($line_arr))
        {
            $line_arr = explode(',', $line_arr);
        }
        foreach ($line_arr as $key => $line) 
        {
           $request_get = $request->get($line); 
           if(isset($user->{$line}) && !empty($request_get))
           {
                if($line == 'password')
                {
                   $request_get = Hash::make($request_get);
                }
                $user->update([$line=>$request_get]);
           }
        }
    }

}
