<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserLevel;

use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\UserRepository;

use EasyWeChat\Factory;
use Config;
use Log;
use Storage;

class UserController extends Controller
{

	private $couponRepository;
    private $couponUserRepository;
    private $userRepository;
    public function __construct(
        UserRepository $userRepo,
        CouponUserRepository $couponUserRepo, 
        CouponRepository $couponRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->userRepository=$userRepo;
    }

    /**
     * 获取我的订单记录
     *
     * @SWG\Get(path="/api/shop/myself/get_orders/{type}",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的订单记录",
     *   description="获取我的订单记录,需要带上token参数后获取",
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
     *     in="path",
     *     name="type",
     *     type="integer",
     *     description="类型 1=>全部;2=>待付款;3=>待发货;4=>待收货(待确认);5=>待评价(已完成)",
     *     required=true,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认是0",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="单次取多少条数据,可不传默认是20",
     *     required=false,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回订单数据列表",
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
    public function getMyordersOfType(Request $request,$type)
    {
        $user = auth()->user();
        $skip = 0;
        $take = 20;
        if($request->has('skip'))
        {
            $skip = $request->get('skip');
        }
        if($request->has('take'))
        {
            $take = $request->get('take');
        }
        return zcjy_callback_data(app('commonRepo')->orderRepo()->ordersOfType($user,$type,$skip,$take));
    }

    /**
     * 获取我的订单详情
     *
     * @SWG\Get(path="/api/shop/myself/get_order/{id}",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的订单详情",
     *   description="获取我的订单详情,需要带上token参数后获取",
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
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="订单id",
     *     required=true,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回订单详情",
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
    public function getOrderDetail(Request $request,$id)
    {
        $order = app('commonRepo')->orderRepo()->findWithoutFail($id);
        if(empty($order))
        {
            return zcjy_callback_data('没有找到该订单',1);
        }
        $order = app('commonRepo')->orderRepo()->dealWithOneOrder($order);
        $items = $order->items;
        return zcjy_callback_data(['order'=>$order,'items'=>$items]);
    }

    /**
     * 取消订单
     *
     * @SWG\Get(path="/api/shop/myself/cancle_order/{id}",
     *   tags={"商城显示模块-我的"},
     *   summary="取消订单",
     *   description="取消订单,需要带上token参数后获取",
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
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="订单id",
     *     required=true,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="reason",
     *     type="string",
     *     description="取消原因 没有可不填",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回订单详情",
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
    public function cancelOrderAction(Request $request,$id)
    {
        return app('commonRepo')->orderRepo()->cancelOrderApi(auth()->user(),$id,$request->get('reason'),optional(auth()->user())->nickname);
    }

    /**
     * 发起订单商品评价
     *
     * @SWG\Post(path="/api/shop/myself/topic_order",
     *   tags={"商城显示模块-我的"},
     *   summary="发起订单商品评价",
     *   description="发起订单商品评价,需要带上token参数后获取",
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
     *     name="item_id",
     *     type="integer",
     *     description="订单item_id ",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="content",
     *     type="string",
     *     description="评论内容 必填",
     *     required=true,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="all_level",
     *     type="integer",
     *     description="描述相符评价12345五个等级",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="overall_level",
     *     type="integer",
     *     description="质量满意评价12345五个等级",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="service_level",
     *     type="integer",
     *     description="服务态度评价12345五个等级",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="logistics_level",
     *     type="integer",
     *     description="物流服务评价12345五个等级",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="product_id",
     *     type="integer",
     *     description="商品id",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="spec_id",
     *     type="integer",
     *     description="规格id",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="图片,视频 多个用,隔开",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="url",
     *     type="string",
     *     description="文件地址 多个用,隔开",
     *     required=false,
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
    public function evalPublish(Request $request){
        $input = $request->all();
        $varify = app('commonRepo')->varifyInputParam($input,app('commonRepo')->productEvalRepo()->model()::$rules,'key');
        if($varify){
            return zcjy_callback_data($varify,1);
        }
        $user = auth()->user();
        $input['user_id'] = $user->id;
        if(array_key_exists('anonymous', $input))
        {
            $input['anonymous'] = 1;
        }
        $eval = app('commonRepo')->productEvalRepo()->model()::create($input);
        app('commonRepo')->productEvalRepo()->attachEval($eval,$input);
        if(isset($input['item_id']))
        {
            app('commonRepo')->productEvalRepo()->dealItemTopiced($input['item_id']);
        }
        return zcjy_callback_data('添加评价成功');
    }


    /**
     * 获取我的积分记录
     *
     * @SWG\Get(path="/api/shop/myself/get_credits_log",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的积分记录",
     *   description="获取我的积分记录,需要带上token参数后获取",
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
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认是0",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="单次取多少条数据,可不传默认是20",
     *     required=false,
     *   ), 
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="可不传 默认和传1是全部 2 获得 3消耗使用",
     *     required=false,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回积分数据列表及当前用户剩余总积分",
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
    public function creditLogs(Request $request)
    {
        $user = auth()->user();
        $skip = 0;
        $take = 18;
        if ($request->has('skip')) 
        {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) 
        {
            $take = $request->input('take');
        }
        $type = 1;
        if($request->has('type'))
        {
            $type = $request->input('type');
        }
        $creditLogs = app('commonRepo')->creditLogRepo()->creditLogs($user,$skip,$take,$type);
        return zcjy_callback_data(['num'=>$user->credits,'list'=>$creditLogs]);
    }

    /**
     * 获取我的收藏商品列表
     *
     * @SWG\Get(path="/api/shop/myself/get_collect_products",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的收藏商品列表",
     *   description="获取我的收藏商品列表,需要带上token参数后获取",
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
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认是0",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="单次取多少条数据,可不传默认是20",
     *     required=false,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回收藏列表",
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
    public function productListCollect(Request $request)
    {
        $user = auth()->user();
        $collections=$user->collections();
        $skip = 0;
        $take = 18;
        $all_page=1;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $all_page= ceil($collections->count() / $take);
        $productList = $collections
        ->orderBy('created_at','desc')
        ->skip($skip)
        ->take($take)
        ->get();
        foreach ($productList as $key => $value) {
             $value['user_price'] = app('commonRepo')->getMemberPrice($user,$value);
        }
        $productList = app('commonRepo')->productRepo()->attachMemberPrice($productList);
        return ['status_code' => 0, 'data' => $productList,'all_page'=>$all_page];  
    }


    /**
     * 订单确认收货
     *
     * @SWG\Get(path="/api/shop/myself/order_confirm/{order_id}",
     *   tags={"商城显示模块-我的"},
     *   summary="订单确认收货",
     *   description="订单确认收货,需要带上token参数后获取",
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
     *     in="path",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
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
    public function enterOrder(Request $request,$order_id)
    {
        return app('commonRepo')->orderRepo()->confirmOrderApi($order_id,auth()->user()->mobile);
    }


    /**
     * 查找订单物流
     *
     * @SWG\Get(path="/api/shop/myself/order_search_wuliu/{order_id}",
     *   tags={"商城显示模块-我的"},
     *   summary="查找订单物流",
     *   description="查找订单物流,需要带上token参数后获取",
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
     *     in="path",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
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
    public function searchOrderKuaiDi(Request $request,$order_id)
    {
        return app('commonRepo')->orderRepo()->searchKuaiDiWebApi($order_id);
    }

    /**
     * 发送订单发货提醒
     *
     * @SWG\Get(path="/api/shop/myself/order_notify/{order_id}",
     *   tags={"商城显示模块-我的"},
     *   summary="发送订单发货提醒",
     *   description="发送订单发货提醒,需要带上token参数后获取",
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
     *     in="path",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
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
    public function orderNotify(Request $request,$order_id)
    {
        $order = app('commonRepo')->orderRepo()->findWithoutFail($order_id);
        if(empty($order))
        {
            return zcjy_callback_data('没有找到该订单',1);
        }
        return zcjy_callback_data('发送提醒成功');
    }

    /**
     * 设置安全码
     *
     * @SWG\Get(path="/api/shop/myself/set_safe_code",
     *   tags={"商城显示模块-我的"},
     *   summary="设置安全码",
     *   description="设置安全码,需要带上token参数后获取",
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
     *     name="safe_code",
     *     type="string",
     *     description="安全码",
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
    public function setSafaCode(Request $request)
    {
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'mobile,code,safe_code');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        #比较验证码
        if(\Zcjy::cache()::get('zcjy_user_'.$input['mobile']) != $input['code'])
        {
            return zcjy_callback_data('验证码错误',1);
        }

        $user = auth()->user();

        if($input['mobile'] != $user->mobile)
        {
            return zcjy_callback_data('手机号与绑定的手机号不一致',1);
        }

       
        $user->update(['safe_code'=>$input['safe_code']]);
        return zcjy_callback_data('设置安全码成功');
    }

    /**
     * 设置支付宝账号及姓名
     *
     * @SWG\Get(path="/api/shop/myself/set_alipay_count",
     *   tags={"商城显示模块-我的"},
     *   summary="设置支付宝账号及姓名",
     *   description="设置支付宝账号及姓名,需要带上token参数后获取;需要之前设置的安全码设置",
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
     *     name="safe_code",
     *     type="string",
     *     description="安全码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="alipay_account",
     *     type="string",
     *     description="支付宝账号",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="string",
     *     description="姓名",
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
    public function setAlipayAccount(Request $request)
    {
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'safe_code,alipay_account,name');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        $user = auth()->user();

        if(empty($user->safe_code))
        {
              return zcjy_callback_data('请先设置安全码',1);
        }

        if($user->safe_code != $input['safe_code'])
        {
             return zcjy_callback_data('安全码错误,请重新输入',1);
        }

        $user->update(['alipay_account'=>$input['alipay_account'],'name'=>$input['name']]);
        return zcjy_callback_data('设置账号成功');
    }


    /**
     * 小程序登录
     * @param  Request $requet [description]
     * @return [type]          [description]
     */
    public function loginMiniprogram(Request $requet)
    {
        $input = $requet->all();

        if (!$requet->has('code') || empty($requet->input('code'))) {
            return ['status_code'=>1,'data'=>'参数不正确'];
        }
        $app = Factory::miniProgram(Config::get('wechat.mini_program.default'));
        $result = $app->auth->session($requet->input('code'));

        Log::info($result);

        $unionid = null;
        if (array_key_exists('unionid', $result)) {
            $unionid = $result['unionid'];
        }

        $parent_id = null;
        if (array_key_exists('parent_id', $input)) {
            $parent_id = $input['parent_id'];
        }

        @$user = $this->userRepository->processRecommendRelation($result['openid'], $parent_id, $unionid);

        // $user = null;
        // if (array_key_exists('unionid', $result)) {
        //     //有UNION ID
        //     $user = User::where('unionid', $result['unionid'])->first();
        // } else {
        //     //只有OPEN ID
        //     $user = User::where('openid', $result['openid'])->first();
        // }
        // $newUser = false;
        // if (empty($user)) {
        //     //新用户
        //     //分销权限
        //     $is_distribute = 0;
        //     if (getSettingValueByKeyCache('distribution_condition') == '注册用户' && getSettingValueByKeyCache('distribution') == '是') {
        //         $is_distribute = 1;
        //     }
        //     //用户等级
        //     $first_level = \App\Models\UserLevel::orderBy('amount', 'asc')->first();
        //     $user_level  = empty($first_level) ? 0 : $first_level->id;

        //     $user = User::create([
        //         'openid' => $result['openid'],
        //         'unionid' => $result['unionid'],
        //         'user_level' => $user_level,
        //         'is_distribute' => $is_distribute
        //     ]);
        //     //处理推荐人关系
        //     if ($requet->has('parent_openid') && !empty($requet->input('parent_openid'))) {
                
        //     }

        //     $newUser = true;
        // }

        $this->updateUserInfo($user, $input['userInfo']);

        $token = auth()->login($user);

        return ['status_code' => 0, 'data' => ['token' => $token]];
    }

    public function updateUserInfo($user, $userInfo)
    {
        $userInfo = json_decode($userInfo, true);
        $user->update($userInfo);
    }

    /**
     * 用户登出
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postLogout(Request $request)
    {
    	auth()->logout();
    	return ['status_code' => 0, 'data' => '退出登录'];
    }

    /**
     * 获取用户信息带用户等级
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function userInfo(Request $request)
    {
    	$user = auth()->user();
    	$userLevel = null;
    	if( funcOpen('FUNC_MEMBER_LEVEL') ){
            $userLevel = UserLevel::where('id', $user->user_level)->first();
        }
        return ['status_code' => 0, 'data' => [
        	'user' => $user,
        	'userLevel' => $userLevel
        ]];
    }


    /**
     * 用户余额记录
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function funds(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
//        $moneyLogs = $user->moneyLogs()->skip($skip)->take($take)->get();
        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take);
        return ['status_code' => 0, 'data' => $moneyLogs];
    }

    /**
     * 用户分佣记录
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function bouns(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take, '分佣');
        return ['status_code' => 0, 'data' => $moneyLogs];
    }

    /**
     * 分销推荐人列表
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function parterners(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $fellows = $this->userRepository->followMembers($user, $skip, $take);
        return ['status_code' => 0, 'data' => $fellows];
    }
    
    /**
     * 获取用户的优惠券
     * @param  Request $request [description]
     * @param  integer $type    [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function coupons(Request $request, $type = -1)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $coupons = $this->couponRepository->couponGetByStatus($user, $type, $skip, $take);
        return ['status_code' => 0, 'data' => $coupons];
    }

    public function distributionCode(Request $request)
    {
        $user = auth()->user();

        $folderpath = '/qrcodes'; 
        $filename = 'minicode_'.$user->id.'.png';

        $filepath = $folderpath.'/'.$filename;

        if(Storage::exists($filepath)){

            return ['status_code' => 0, 'data' => $filepath];

        } else {
            $app = Factory::miniProgram(Config::get('wechat.mini_program.default'));

            $response = $app->app_code->getUnlimit('user_id='.$user->id, [
                'page' => 'pages/index/index',
                'width' => 430
            ]);

            $filename = $response->saveAs(public_path().$folderpath, $filename);

            return ['status_code' => 0, 'data' => $filepath];
        }
    }

    public function distributionCodeOfProduct(Request $request)
    {
        $input = $request->all();
        if (!array_key_exists('product_id', $input)) {
            return ['status_code' => 1, 'data' => '参数不正确'];
        }

        $user = auth()->user();

        $folderpath = '/qrcodes'; 
        $filename = 'minicode_'.$user->id.'_product_'.$input['product_id'].'.png';

        $filepath = $folderpath.'/'.$filename;

        if(Storage::exists($filepath)){

            return ['status_code' => 0, 'data' => $filepath];

        } else {
            $app = Factory::miniProgram(Config::get('wechat.mini_program.default'));

            $response = $app->app_code->getUnlimit('user_id='.$user->id.'&product_id='.$input['product_id'], [
                'page' => 'pages/product/product',
                'width' => 430
            ]);

            $filename = $response->saveAs(public_path().$folderpath, $filename);

            return ['status_code' => 0, 'data' => $filepath];
        }
    }
    
}