<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\User;
use Log;
use Config;


class AuthController extends Controller
{

    private $userRepository;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
        $this->middleware('auth:api', ['except' => ['login', 'sms', 'register', 'resetpassword']]);
    }

    private function findUserWithoutFail($share_code)
    {
        try {
            return User::where('share_code', $share_code)->first();
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = request(['mobile', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['status_code' => 401, 'data' => ['error' => '登录信息不正确']], 401);
        }

        return $this->respondWithToken($token);
    }

    //发送短信 
    public function sms(Request $request)
    {
        $inputs = $request->all();
        if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
            return response()->json(['status_code' => 1, 'data' => ['error' => '参数不正确']]);
        }
        $mobile = $inputs['mobile'];
        if ( !preg_match("/^1[123456789]{1}\d{9}$/", $mobile) ) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请输入正确的手机号']]);
        }
        return response()->json(['status_code' => 0, 'data' => ['message' => app('commonRepo')->sendVerifyCode($mobile)]]);
    }

    public function register(Request $request)
    {
        $inputs = $request->all();

        if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请输入手机号']]);
        }
        //用户是否已经注册过
        $userCount = User::where('mobile', $inputs['mobile'])->count();
        if ($userCount) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '该用户已经注册过']]);
        }
        if (!array_key_exists('code', $inputs) || $inputs['code'] == '') {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请输入验证码']]);
        }
        if (!array_key_exists('codeVerify', $inputs) || $inputs['codeVerify'] == '' || $inputs['codeVerify'] != $inputs['code']) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '验证码不正确']]);
        }

        if (!array_key_exists('nickname', $inputs) || $inputs['nickname'] == '') {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请输入昵称']]);
        }

        $name = '';
        if (array_key_exists('name', $inputs)) {
            $name = $inputs['name'];
        }

        $sex = 0;
        if (array_key_exists('sex', $inputs)) {
            $sex = $inputs['sex'];
        }

        if (!array_key_exists('password', $inputs) ||  strlen($inputs['password']) < 6){
            return response()->json(['status_code' => 1, 'data' => ['error' => '密码最少需要输入6位密码']]);
        }

        if (!array_key_exists('password', $inputs) || !array_key_exists('confirm_password', $inputs) || $inputs['password'] != $inputs['confirm_password']){
            return response()->json(['status_code' => 1, 'data' => ['error' => '两次密码输入不一致, 请重新输入']]);
        }

        $user = null;
        $leader1 = 0;
        $leader2 = 0;
        $leader3 = 0;
        if (Config::get('zcjy.OPEN_SHARE')){
            if (!array_key_exists('tuijianma', $inputs) || empty($inputs['tuijianma']) ) {
                return response()->json(['status_code' => 1, 'data' => ['error' => '请输入推荐码']]);
            }
            
            if ( $inputs['tuijianma'] != '20140617' ) {
                //推荐关系
                $parent = $this->userRepository->FindUserByShareCode( strtolower($inputs['tuijianma']) );

                if (empty($parent)) {
                    return response()->json(['status_code' => 1, 'data' => ['error' => '请输入有效推荐码']]);
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
            'name' => $name,
            'sex' => $sex,
            'mobile' => $inputs['mobile'],
            'password' => bcrypt($inputs['password']),
            'share_code' => app('commonRepo')->randomCode(),
            'leader1' => $leader1,
            'leader2' => $leader2,
            'leader3' => $leader3
        ]);

        $token = auth()->login($user);
        return  $this->respondWithToken($token);
    }

    /**
     * 面对面开通账号
     *
     * @SWG\Get(path="/api/shop/myself/registerF2F",
     *   tags={"商城显示模块-我的"},
     *   summary="面对面开通账号",
     *   description="面对面开通账号,需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="mobile",
     *     type="string",
     *     description="手机号",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="integer",
     *     description="验证码",
     *     required=true,
     *   ), 
     *    @SWG\Parameter(
     *     in="query",
     *     name="codeVerify",
     *     type="integer",
     *     description="重复验证码 必须和上面的验证码一致",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="string",
     *     description="姓名",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="nickname",
     *     type="string",
     *     description="昵称",
     *     required=true,
     *   ),  
     *    @SWG\Parameter(
     *     in="query",
     *     name="password",
     *     type="string",
     *     description="密码",
     *     required=true,
     *   ), 
     *    @SWG\Parameter(
     *     in="query",
     *     name="confirm_password",
     *     type="string",
     *     description="重复密码",
     *     required=true,
     *   ),  
     *    @SWG\Parameter(
     *     in="query",
     *     name="tuijianma",
     *     type="string",
     *     description="推荐码",
     *     required=true,
     *   ),  
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回操作结果",
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
    public function registerF2F(Request $request)
    {
        try {
            $inputs = $request->all();

            if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
                return response()->json(['status_code' => 1, 'data' => ['error' => '请输入手机号']]);
            }
            //用户是否已经注册过
            $userCount = User::where('mobile', $inputs['mobile'])->count();
            if ($userCount) {
                return response()->json(['status_code' => 1, 'data' => ['error' => '该用户已经注册过']]);
            }
            if (!array_key_exists('code', $inputs) || $inputs['code'] == '') {
                return response()->json(['status_code' => 1, 'data' => ['error' => '请输入验证码']]);
            }
            if (!array_key_exists('codeVerify', $inputs) || $inputs['codeVerify'] == '' || $inputs['codeVerify'] != $inputs['code']) {
                return response()->json(['status_code' => 1, 'data' => ['error' => '验证码不正确']]);
            }

            if (!array_key_exists('nickname', $inputs) || $inputs['nickname'] == '') {
                return response()->json(['status_code' => 1, 'data' => ['error' => '请输入昵称']]);
            }
            if (!array_key_exists('name', $inputs) || $inputs['name'] == '') {
                return response()->json(['status_code' => 1, 'data' => ['error' => '请输入姓名']]);
            }
            if (!array_key_exists('password', $inputs) ||  strlen($inputs['password']) < 6){
                return response()->json(['status_code' => 1, 'data' => ['error' => '密码最少需要输入6位密码']]);
            }

            if (!array_key_exists('password', $inputs) || !array_key_exists('confirm_password', $inputs) || $inputs['password'] != $inputs['confirm_password']){
                return response()->json(['status_code' => 1, 'data' => ['error' => '两次密码输入不一致, 请重新输入']]);
            }
            if (!array_key_exists('tuijianma', $inputs) || $inputs['tuijianma'] == '') {
                return response()->json(['status_code' => 1, 'data' => ['error' => '请输入推荐码']]);
            }
            
            $user = null;
            $leader1 = 0;
            $leader2 = 0;
            $leader3 = 0;


            if ( array_key_exists('tuijianma', $inputs) && !empty($inputs['tuijianma'] && $inputs['tuijianma'] != '20140617') ) {
                //推荐关系
                $parent = $this->userRepository->FindUserByShareCode($inputs['tuijianma']);
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
            $user = User::create([
                'nickname' => $inputs['nickname'],
                'name' => $inputs['name'],
                'mobile' => $inputs['mobile'],
                'password' => bcrypt($inputs['password']),
                'share_code' => app('commonRepo')->randomCode(),
                'leader1' => $leader1,
                'leader2' => $leader2,
                'leader3' => $leader3
            ]);

            return response()->json(['status_code' => 0, 'data' => ['message' => '注册成功']]);
        } catch (Exception $e) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '注册失败']]);
        }
    }


    public function resetpassword(Request $request)
    {
        $inputs = $request->all();

        if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请输入手机号']]);
        }
        //用户是否已经注册过
        $user = User::where('mobile', $inputs['mobile'])->first();
        if (empty($user)) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '用户不存在']]);
        }
        if (!array_key_exists('code', $inputs) || $inputs['code'] == '') {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请输入验证码']]);
        }
        if (!array_key_exists('codeVerify', $inputs) || $inputs['codeVerify'] == '' || $inputs['codeVerify'] != $inputs['code']) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '验证码不正确']]);
        }

        if (!array_key_exists('password', $inputs) ||  strlen($inputs['password']) < 6){
            return response()->json(['status_code' => 1, 'data' => ['error' => '密码最少需要输入6位密码']]);
        }

        if (!array_key_exists('password', $inputs) || !array_key_exists('confirm_password', $inputs) || $inputs['password'] != $inputs['confirm_password']){
            return response()->json(['status_code' => 1, 'data' => ['error' => '两次密码输入不一致, 请重新输入']]);
        }
        
        $user->password = bcrypt($inputs['password']);
        $user->save();
        
        return response()->json(['status_code' => 0, 'data' => ['message' => '密码重置成功']]);
        
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        if ($user->member && empty($user->share_code)) {
            $user->share_code = app('commonRepo')->randomCode();
            $user->save();
        }
        //推荐人
        if ($user->leader1) {
            $user['invitor'] = User::where('id', $user->leader1)->first();
        }
        return response()->json(['status_code' => 0, 'data' => $user]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['status_code' => 0, 'data' => ['message' => '退出登录']] );
    } 

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(['status_code' => 0, 'data' => [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]]);
    }



}